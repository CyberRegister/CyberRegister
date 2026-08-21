<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use LaravelWebauthn\Models\WebauthnKey;
use Tests\TestCase;

class WebauthnTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * The registration page renders and is wired to the application layout.
     */
    public function testWebauthnRegisterView()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('webauthn.create'));

        $response->assertStatus(200)
            ->assertViewIs('webauthn::register')
            ->assertSee('vendor/webauthn/webauthn.js')
            ->assertDontSee('cdnjs.cloudflare.com')
            ->assertDontSee('unpkg.com');
    }

    /**
     * Registering a key is only possible while logged in.
     */
    public function testWebauthnRegisterRequiresLogin()
    {
        $response = $this->get(route('webauthn.create'));
        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /**
     * A user without a key is not asked for one.
     */
    public function testUserWithoutKeyIsNotChallenged()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get('/home');

        $response->assertStatus(200);
    }

    /**
     * A user with a registered key is redirected to the assertion page.
     */
    public function testUserWithKeyIsChallenged()
    {
        $user = $this->getWebauthnUser();
        $response = $this
            ->actingAs($user)
            ->get('/home');

        $response->assertStatus(302)
            ->assertRedirect(route('webauthn.login'));
    }

    /**
     * The assertion page renders for a user holding a key.
     */
    public function testWebauthnAuthenticateView()
    {
        $user = $this->getWebauthnUser();
        $response = $this
            ->actingAs($user)
            ->get(route('webauthn.login'));

        $response->assertStatus(200)
            ->assertViewIs('webauthn::authenticate')
            ->assertSee('vendor/webauthn/webauthn.js')
            ->assertDontSee('stackpath.bootstrapcdn.com')
            ->assertDontSee('ssl.gstatic.com');
    }

    /**
     * The key is bound to the user through the relation on the model.
     */
    public function testUserHasWebauthnKeysRelation()
    {
        $user = $this->getWebauthnUser();

        $this->assertCount(1, $user->webauthnKeys);
        $this->assertInstanceOf(WebauthnKey::class, $user->webauthnKeys->first());
    }

    /**
     * Build a user that already registered a credential.
     *
     * @return User
     */
    private function getWebauthnUser(): User
    {
        $user = User::factory()->create();

        $key = new WebauthnKey();
        $key->user_id = $user->id;
        $key->name = 'test key';
        $key->credentialId = 'test-credential-id';
        $key->type = 'public-key';
        $key->transports = [];
        $key->attestationType = 'none';
        $key->trustPath = ['type' => 'Webauthn\TrustPath\EmptyTrustPath'];
        $key->aaguid = '00000000-0000-0000-0000-000000000000';
        $key->credentialPublicKey = 'dGVzdA==';
        $key->counter = 0;
        $key->save();

        return $user->refresh();
    }
}
