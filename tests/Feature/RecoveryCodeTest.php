<?php

namespace Tests\Feature;

use App\Models\RecoveryCode;
use App\Models\TwoFAKey;
use App\Models\User;
use App\Support\RecoveryCodes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RecoveryCodeTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A user with 2FA switched on.
     *
     * @return User
     */
    private function userWith2fa(): User
    {
        $user = User::factory()->create();
        TwoFAKey::create(
            [
                'user_id'          => $user->id,
                'google2fa_enable' => true,
                'google2fa_secret' => app('pragmarx.google2fa')->generateSecretKey(),
            ]
        );

        return $user->refresh();
    }

    /**
     * Enabling 2FA hands out a set of codes.
     */
    public function testEnablingTwoFactorIssuesRecoveryCodes()
    {
        $user = $this->userWith2fa();
        $codes = app(RecoveryCodes::class)->generate($user);

        $this->assertCount(RecoveryCodes::COUNT, $codes);
        $this->assertSame(RecoveryCodes::COUNT, app(RecoveryCodes::class)->remaining($user));
    }

    /**
     * Codes are stored hashed, so the database does not hold a way in.
     */
    public function testCodesAreStoredHashed()
    {
        $user = $this->userWith2fa();
        $codes = app(RecoveryCodes::class)->generate($user);

        $stored = RecoveryCode::where('user_id', $user->id)->pluck('code')->all();

        foreach ($codes as $code) {
            $this->assertNotContains($code, $stored);
        }
        $this->assertTrue(Hash::check($codes[0], $stored[0]));
    }

    /**
     * A code lets the holder through.
     */
    public function testValidCodeIsAccepted()
    {
        $user = $this->userWith2fa();
        $codes = app(RecoveryCodes::class)->generate($user);

        $this->assertTrue(app(RecoveryCodes::class)->consume($user, $codes[0]));
    }

    /**
     * A code works once and then does not.
     */
    public function testCodeCannotBeUsedTwice()
    {
        $user = $this->userWith2fa();
        $codes = app(RecoveryCodes::class)->generate($user);
        $service = app(RecoveryCodes::class);

        $this->assertTrue($service->consume($user, $codes[0]));
        $this->assertFalse($service->consume($user, $codes[0]));
        $this->assertSame(RecoveryCodes::COUNT - 1, $service->remaining($user));
    }

    /**
     * One person's code is no use to another.
     */
    public function testCodeOfAnotherUserIsRejected()
    {
        $user = $this->userWith2fa();
        $other = $this->userWith2fa();
        $codes = app(RecoveryCodes::class)->generate($other);

        $this->assertFalse(app(RecoveryCodes::class)->consume($user, $codes[0]));
    }

    /**
     * Nonsense is rejected.
     */
    public function testUnknownCodeIsRejected()
    {
        $user = $this->userWith2fa();
        app(RecoveryCodes::class)->generate($user);

        $this->assertFalse(app(RecoveryCodes::class)->consume($user, 'AAAAA-BBBBB-CCCCC'));
    }

    /**
     * Codes are accepted however they were typed.
     */
    public function testCodeIsAcceptedRegardlessOfCase()
    {
        $user = $this->userWith2fa();
        $codes = app(RecoveryCodes::class)->generate($user);

        $this->assertTrue(app(RecoveryCodes::class)->consume($user, ' '.strtolower($codes[0]).' '));
    }

    /**
     * Issuing a new set retires the old one, so a written down code from
     * before cannot still be used.
     */
    public function testRegeneratingInvalidatesTheOldSet()
    {
        $user = $this->userWith2fa();
        $service = app(RecoveryCodes::class);
        $old = $service->generate($user);
        $new = $service->generate($user);

        $this->assertFalse($service->consume($user, $old[0]));
        $this->assertTrue($service->consume($user, $new[0]));
    }

    /**
     * A recovery code gets a user past the two factor challenge.
     */
    public function testRecoveryCodeSatisfiesTheTwoFactorChallenge()
    {
        $user = $this->userWith2fa();
        $codes = app(RecoveryCodes::class)->generate($user);

        $blocked = $this->actingAs($user)->get('/home');
        $blocked->assertStatus(200)->assertViewIs('auth.google2fa');

        $response = $this
            ->withSession(['_token' => 'test'])
            ->actingAs($user)
            ->post('/2faVerify', ['_token' => 'test', 'one_time_password' => $codes[0]]);

        $response->assertStatus(302);
        $this->assertSame(RecoveryCodes::COUNT - 1, app(RecoveryCodes::class)->remaining($user));
    }

    /**
     * A wrong recovery code does not.
     */
    public function testWrongRecoveryCodeDoesNotSatisfyTheChallenge()
    {
        $user = $this->userWith2fa();
        app(RecoveryCodes::class)->generate($user);

        $response = $this
            ->withSession(['_token' => 'test'])
            ->actingAs($user)
            ->post('/2faVerify', ['_token' => 'test', 'one_time_password' => 'ZZZZZ-ZZZZZ-ZZZZZ']);

        $response->assertStatus(422)->assertViewIs('auth.google2fa');
        $this->assertSame(RecoveryCodes::COUNT, app(RecoveryCodes::class)->remaining($user));
    }

    /**
     * Enabling 2FA before generating a secret is refused rather than
     * dereferencing a relation that is not there.
     */
    public function testEnableWithoutSecretIsRefused()
    {
        $user = User::factory()->create();

        $response = $this
            ->withSession(['_token' => 'test'])
            ->actingAs($user)
            ->post('/2fa', ['_token' => 'test', 'verify-code' => '123456']);

        $response->assertStatus(302)->assertSessionHas('error');
    }

    /**
     * Disabling 2FA that was never set up is refused the same way.
     */
    public function testDisableWithoutSecretIsRefused()
    {
        $user = User::factory()->create(['password' => bcrypt('geheim12345')]);

        $response = $this
            ->withSession(['_token' => 'test'])
            ->actingAs($user)
            ->post('/disable2fa', ['_token' => 'test', 'current-password' => 'geheim12345']);

        $response->assertStatus(302)->assertSessionHas('error');
    }

    /**
     * Regenerating before 2FA is on is refused.
     */
    public function testRegenerateBeforeTwoFactorIsEnabledIsRefused()
    {
        $user = User::factory()->create();

        $response = $this
            ->withSession(['_token' => 'test'])
            ->actingAs($user)
            ->post('/2fa/herstelcodes', ['_token' => 'test']);

        $response->assertStatus(302)->assertSessionHas('error');
        $this->assertSame(0, app(RecoveryCodes::class)->remaining($user));
    }

    /**
     * The management page reports how many are left.
     */
    public function testTwoFactorPageShowsRemainingCount()
    {
        $user = $this->userWith2fa();
        app(RecoveryCodes::class)->generate($user);
        app(RecoveryCodes::class)->consume($user, app(RecoveryCodes::class)->generate($user)[0]);

        $response = $this->actingAs($user)->get('/2fa');

        $response->assertStatus(200)
            ->assertSee('Herstelcodes')
            ->assertSee((string) (RecoveryCodes::COUNT - 1));
    }
}
