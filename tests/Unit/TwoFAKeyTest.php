<?php

namespace Tests\Unit;

use App\TwoFAKey;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwoFAKeyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assert TwoFAKey might have a relation with a user.
     */
    public function testTwoFAKeyHasUserRelation()
    {
        $user = factory(User::class)->create();
        $this->assertEmpty($user->twoFAKey);
        $google2fa = app('pragmarx.google2fa');
        // Add the secret key to the registration data
        $key = TwoFAKey::create([
            'user_id'          => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $google2fa->generateSecretKey(),
        ]);
        $this->assertEquals($user->cyber_code, $key->user->cyber_code);
    }

    /**
     * Test decryption of google2fa_secret
     */
    public function testTwoFAKeyGoogle2faSecretAttributeEncryption(){
        $user = factory(User::class)->create();
        $key = TwoFAKey::create([
            'user_id'          => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => 'henk',
        ]);
        $this->assertEquals('henk', $key->google2fa_secret);
    }
}
