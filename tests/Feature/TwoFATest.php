<?php

namespace Tests\Feature;

use App\TwoFAKey;
use App\User;
use Faker\Factory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use PragmaRX\Google2FALaravel\Exceptions\InvalidSecretKey;
use Tests\TestCase;

class TwoFATest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

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
     * Test OTP failure
     */
    public function test2FALoginFail()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();
        $user = $this->get2FAUser($secret);
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/2faVerify',[
                '_token' => 'test',
                'one_time_password' => '12345'
            ]);
        $response->assertStatus(422)
            ->assertViewIs('auth.google2fa');
    }

    /**
     * Test OTP hard failure
     */
    public function test2FALoginEmpty()
    {
        $user = $this->get2FAUser('');
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/2faVerify',[
                '_token' => 'test',
                'one_time_password' => '12345'
            ]);
        $response->assertStatus(500)
            ->assertSee('PragmaRX\Google2FALaravel\Exceptions\InvalidSecretKey: Secret key cannot be empty.');
    }

    /**
     * Test OTP failure
     */
    public function test2FALogin()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();
        $user = $this->get2FAUser($secret);
        $response = $this
            ->withSession(['_token'=>'test'])
            ->actingAs($user)
            ->post('/2faVerify',[
                '_token' => 'test',
                'one_time_password' => $google2fa->getCurrentOtp($secret)
            ]);
        $response->assertStatus(302)
            ->assertRedirect('/');
    }

    /**
     * @param string $secret
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
