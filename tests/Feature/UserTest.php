<?php

namespace Tests\Feature;

use App\Expertise;
use App\PcePoint;
use App\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * Check redirect to /login when going to the /users page.
     */
    public function testUserHomeRedirect()
    {
        $response = $this->get('/users');
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * Check JSON request Unauthenticated . .
     */
    public function testUserJsonRedirect()
    {
        $response = $this->json('GET', '/users');
        $response->assertStatus(401)
            ->assertExactJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Check redirect to /home when going to the /users page.
     */
    public function testUserIndexUser()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/users');
        $response->assertStatus(200)->assertViewHas('users', User::all());
    }

    /**
     * Check 200 page.
     */
    public function testUserCreate()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/users/create');
        $response->assertStatus(200);
    }

    /**
     * Check user creation.
     */
    public function testUserStore()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();
        $password = $faker->password;
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->post('/users', [
                'cyber_code' => $faker->bothify('??##??'),
                'first_name' => $faker->firstName,
                'middle_name' => 'de',
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'date_of_birth' => $faker->date(),
                'place_of_birth' => $faker->city,
                'password' => $password,
                'password_confirmation' => $password,
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/users');
        $this->assertCount(2, User::all());
    }

    /**
     * Check redirect on attempt to edit user.
     */
    public function testUserEditError()
    {
        $user = factory(User::class)->create();
        $userTwo = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/users/'.$userTwo->cyber_code.'/edit');
        $response->assertStatus(403);
    }

    /**
     * Check controller can get edit view for user.
     */
    public function testUserEditIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $userTwo = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/users/'.$userTwo->cyber_code.'/edit');
        $response->assertStatus(200);
    }

    /**
     * Check user can get edit view for own user.
     */
    public function testUserEditSelf()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/users/'.$user->cyber_code.'/edit');
        $response->assertStatus(200);
    }

    /**
     * Check redirect on attempt to edit user.
     */
    public function testUserUpdateDenied()
    {
        $user = factory(User::class)->create();
        $userTwo = factory(User::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/users/'.$userTwo->cyber_code, [
                'cyber_code' => $faker->bothify('??##??'),
                'first_name' => $faker->firstName,
                'middle_name' => 'de',
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'date_of_birth' => $faker->date(),
                'place_of_birth' => $faker->city,
                '_token' => 'test'
            ]);
        $response->assertStatus(403);
    }

    /**
     * Check controller can edit user.
     */
    public function testUserUpdateIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $userTwo = factory(User::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/users/'.$userTwo->cyber_code, [
                'cyber_code' => $faker->bothify('??##??'),
                'first_name' => $faker->firstName,
                'middle_name' => 'de',
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'date_of_birth' => $faker->date(),
                'place_of_birth' => $faker->city,
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/users');
    }

    /**
     * Check user can edit own user.
     */
    public function testUserUpdateSelf()
    {
        $user = factory(User::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/users/'.$user->cyber_code, [
                'cyber_code' => $faker->bothify('??##??'),
                'first_name' => $faker->firstName,
                'middle_name' => 'de',
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'date_of_birth' => $faker->date(),
                'place_of_birth' => $faker->city,
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/users');
    }

    /**
     * Check redirect on attempt to delete user.
     */
    public function testUserDestroyDenied()
    {
        $user = factory(User::class)->create();
        $userTwo = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/users/'.$userTwo->cyber_code);
        $response->assertStatus(403);
    }

    /**
     * Check controller delete user.
     */
    public function testUserDestroyIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $userTwo = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/users/'.$userTwo->cyber_code);
        $response->assertStatus(302)->assertRedirect('/users');
        $this->assertCount(1, User::all());
    }

    /**
     * Check user can delete own user.
     */
    public function testUserDestroySelf()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/users/'.$user->cyber_code);
        $response->assertStatus(302)->assertRedirect('/users');
        $this->assertEmpty(User::all());

    }

    /**
     * Check user can view own user.
     */
    public function testUserShowSelf()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/users/'.$user->cyber_code);
        $response->assertStatus(200);
    }

    /**
     * Check user can view other user.
     */
    public function testUserShow()
    {
        $user = factory(User::class)->create();
        $userTwo = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/users/'.$userTwo->cyber_code);
        $response->assertStatus(200);
    }

    /**
     * Check user delete also removes Expertise(s) and PcePoint(s)
     */
    public function testUserDestroyRecursive()
    {
        $user = factory(User::class)->create();
        $expertise = factory(Expertise::class)->create();
        $expertise->user()->associate($user);
        $expertise->save();
        $this->assertCount(1, Expertise::all());
        $pcePoint = new PcePoint;
        $pcePoint->user()->associate($user);
        $pcePoint->points = 1;
        $pcePoint->save();
        $this->assertCount(1, PcePoint::all());
        $response = $this
            ->actingAs($user)
            ->delete('/users/'.$user->cyber_code);
        $response->assertStatus(302)->assertRedirect('/users');
        $this->assertEmpty(PcePoint::all());
        $this->assertEmpty(Expertise::all());
    }
}