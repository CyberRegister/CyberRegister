<?php

namespace Tests\Feature;

use App\TwoFAKey;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TwoFATest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;
    /**
     * Check the intercept functionality.
     */
    public function test2FAView()
    {
        $user = $this->get2FAUser();
        $response = $this
            ->actingAs($user)
            ->get('/home');
        $response->assertStatus(200)
            ->assertViewIs('auth.google2fa');
    }

    /**
     * Test OTP failure.
     */
    public function test2FALoginFail()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();
        $user = $this->get2FAUser($secret);
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/2faVerify', [
                '_token'            => 'test',
                'one_time_password' => '12345',
            ]);
        $response->assertStatus(422)
            ->assertViewIs('auth.google2fa');
    }

    /**
     * Test OTP hard failure.
     */
    public function test2FALoginEmpty()
    {
        $user = $this->get2FAUser('');
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/2faVerify', [
                '_token'            => 'test',
                'one_time_password' => '12345',
            ]);
        $response->assertStatus(500)
            ->assertSee('No such file or directory');
    }

    /**
     * Test OTP auth.
     */
    public function test2FALogin()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();
        $user = $this->get2FAUser($secret);
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/2faVerify', [
                '_token'            => 'test',
                'one_time_password' => $google2fa->getCurrentOtp($secret),
            ]);
        $response->assertStatus(302)
            ->assertRedirect('/');
    }

    /**
     * Test 2FA enable full flow.
     */
    public function test2FAEnable()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/2fa');
        $response->assertStatus(200)
            ->assertViewHas('data');
        $this->assertEmpty($response->getOriginalContent()->data['google2fa_url']);
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/generate2faSecret');
        $response->assertStatus(302)
            ->assertRedirect('/2fa')
            ->assertSessionHas('success', 'Geheime sleutel is gegenereerd, voer OTP in om 2FA te activeren.');
        $user = User::find($user->id);
        $this->assertFalse((bool) $user->twoFAKey->google2fa_enable);
        $response = $this
            ->actingAs($user)
            ->get('/2fa');
        $response->assertStatus(200)
            ->assertViewHas('data');
        $this->assertNotEmpty($response->getOriginalContent()->data['google2fa_url']);
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/2fa', [
                '_token'            => 'test',
                'verify-code'       => '12345',
            ]);
        $response->assertStatus(302)
            ->assertRedirect('/2fa')
            ->assertSessionHas('error', 'OTP code verkeerd, probeer nogmaals.');
        $google2fa = app('pragmarx.google2fa');
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/2fa', [
                '_token'            => 'test',
                'verify-code'       => $google2fa->getCurrentOtp($user->twoFAKey->google2fa_secret),
            ]);
        $response->assertStatus(302)
            ->assertRedirect('/2fa')
            ->assertSessionHas('success', '2FA is geactiveerd.');
        $user = User::find($user->id);
        $this->assertTrue((bool) $user->twoFAKey->google2fa_enable);
    }

    /**
     * Test 2FA disable flow.
     */
    public function test2FADisable()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();
        $user = $this->get2FAUser($secret);
        $this->assertTrue((bool) $user->twoFAKey->google2fa_enable);
        $response = $this
            ->actingAs($user)
            ->get('/2fa');
        $response->assertStatus(200)
            ->assertViewHas('data');
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/disable2fa', [
                '_token'            => 'test',
                'current-password'  => 'test',
            ]);
        $response->assertStatus(302)
            ->assertRedirect('/2fa')
            ->assertSessionHas('error', 'Je wachtwoord klopt niet, probeer nogmaals.');
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/disable2fa', [
                '_token'            => 'test',
                'current-password'  => 'secret',
            ]);
        $response->assertStatus(302)
            ->assertRedirect('/2fa')
            ->assertSessionHas('success', '2FA is uitgeschakeld.');
        $user = User::find($user->id);
        $this->assertFalse((bool) $user->twoFAKey->google2fa_enable);
    }

    /**
     * @param string $secret
     *
     * @return User
     */
    private function get2FAUser($secret = 'secret'): User
    {
        $user = factory(User::class)->create();
        TwoFAKey::create(
            [
                'user_id'          => $user->id,
                'google2fa_enable' => 1,
                'google2fa_secret' => $secret,
            ]
        );

        return User::find($user->id);
    }
}
