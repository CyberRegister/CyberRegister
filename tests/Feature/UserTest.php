<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;
use Session;

class UserTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * login failed get redirected.
     */
    public function testLoginFail()
    {
        $response = $this
            ->withSession(['_token'=>'test'])
            ->post('/login', [
                'email' => 'annejan@noprotocol.nl',
                'password' => 'badPass',
                '_token' => 'test'
            ]);
        $response->assertStatus(302)
            ->assertRedirect('')
            ->assertSessionHas('errors')
            ->assertSessionHas('_old_input', [
                "email" => 'annejan@noprotocol.nl',
		'_token' => 'test'
            ]);
    }

    /**
     * Login, go to home
     */
    public function testLogin()
    {
        $faker = Factory::create();
        $password = $faker->password;
        $user = factory(User::class)->create(['password' => bcrypt($password)]);
        $response = $this
            ->withSession(['_token'=>'test'])
            ->post('/login', [
                'cyber_code' => $user->cyber_code,
                'password' => $password,
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/home');
    }

    /**
     * Check the homepage / dashboard.
     */
    public function testHome()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/home');
        $response->assertStatus(200);
    }

    /**
     * Check the logout functionality.
     */
    public function testLogout()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->post('/logout');
        $response->assertStatus(302)
            ->assertRedirect('');
    }

    /**
     * Test a password change and login (full flow).
     */
    public function testUserResetPassword()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $response = $this
            ->withSession(['_token'=>'test'])
            ->post('password/email', [
                'email' => $user->email,
                '_token' => 'test'
            ]);
        $response->assertStatus(302)
            ->assertRedirect('/');

        $token = null;

        Notification::assertSentTo(
            [$user],
            ResetPassword::class,
            function ($notification, $channels) use (&$token) {
                $token = $notification->token;
                return true;
            }
        );

        $this->assertNotNull($token);

        $response = $this->get('/password/reset/'.$token);
        $response->assertStatus(200);

        $faker = Factory::create();
        $password = $faker->password;

        $response = $this
            ->withSession(['_token'=>'test'])
            ->post('/password/reset', [
            'email' => $user->email,
            'token' => $token,
            'password' => $password,
            'password_confirmation' => $password,
            '_token' => 'test'
        ]);
        $response->assertStatus(302)->assertRedirect('/home');

        $response = $this
            ->withSession(['_token'=>'test'])
            ->post('/logout', [
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/');

        $response = $this
            ->withSession(['_token'=>'test'])
            ->post('/login', [
                'cyber_code' => $user->cyber_code,
                'password' => $password,
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/home');
    }

    /**
     * Register, go to /home . .
     */
    public function testRegister()
    {
        $faker = Factory::create();
        $password = $faker->password;
        $email = $faker->email;
        $response = $this
            ->withSession(['_token'=>'test'])
            ->post('/register', [
                'cyber_code' => $faker->bothify('??##??'),
                'first_name' => $faker->firstName,
                'middle_name' => 'de',
                'last_name' => $faker->lastName,
                'email' => $email,
                'date_of_birth' => $faker->date(),
                'place_of_birth' => $faker->city,
                'password' => $password,
                'password_confirmation' => $password,
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/home');
        $this->assertCount(1, User::all());
        $this->assertEquals($email, User::first()->email);
    }

}
