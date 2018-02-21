<?php

namespace Tests\Feature;

use App\Expertise;
use App\PcePoint;
use App\CyberExpertise;
use App\Policies\UserPolicy;
use App\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CyberExpertiseTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * Check redirect to /login when going to the /cyberExpertise page.
     */
    public function testCyberExpertiseHomeRedirect()
    {
        $response = $this->get('/cyberExpertise');
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * Check JSON request Unauthenticated . .
     */
    public function testCyberExpertiseJsonRedirect()
    {
        $response = $this->json('GET', '/cyberExpertise');
        $response->assertStatus(401)
            ->assertExactJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Check 200
     */
    public function testCyberExpertiseIndex()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/cyberExpertise');
        $response->assertStatus(200);
    }

    /**
     * Check 403 page.
     */
    public function testCyberExpertiseCreate()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/cyberExpertise/create');
        $response->assertStatus(403);
    }

    /**
     * Check 200 page.
     */
    public function testCyberExpertiseCreateIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->get('/cyberExpertise/create');
        $response->assertStatus(200);
    }

    /**
     * Check user creation.
     */
    public function testCyberExpertiseStore()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->post('/cyberExpertise', [
                'expertise_code' => $faker->bothify('??#'),
                'description' => $faker->paragraph,
                'required_points' => $faker->numberBetween(0, 1000),
                '_token' => 'test'
            ]);
        $response->assertStatus(403);
    }

    /**
     * Check user cyber.
     */
    public function testCyberExpertiseStoreIsController()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->post('/cyberExpertise', [
                'expertise_code' => $faker->bothify('??#'),
                'description' => $faker->paragraph,
                'required_points' => $faker->numberBetween(0, 1000),
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/cyberExpertise');
        $this->assertCount(1, CyberExpertise::all());
    }

    /**
     * Check redirect on attempt to edit CyberExpertise.
     */
    public function testCyberExpertiseEditError()
    {
        $user = factory(User::class)->create();
        $cyberExpertise = factory(CyberExpertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/cyberExpertise/'.$cyberExpertise->expertise_code.'/edit');
        $response->assertStatus(403);
    }

    /**
     * Check controller can get edit view for CyberExpertise.
     */
    public function testCyberExpertiseEditIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $cyberExpertise = factory(CyberExpertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/cyberExpertise/'.$cyberExpertise->expertise_code.'/edit');
        $response->assertStatus(200);
    }

    /**
     * Check redirect on attempt to edit CyberExpertise.
     */
    public function testCyberExpertiseUpdateDenied()
    {
        $user = factory(User::class)->create();
        $cyberExpertise = factory(CyberExpertise::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/cyberExpertise/'.$cyberExpertise->expertise_code, [
                'expertise_code' => $faker->bothify('??#'),
                'description' => $faker->paragraph,
                'required_points' => $faker->numberBetween(0, 1000),
                '_token' => 'test'
            ]);
        $response->assertStatus(403);
    }

    /**
     * Check controller can edit CyberExpertise.
     */
    public function testCyberExpertiseUpdateIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $cyberExpertise = factory(CyberExpertise::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/cyberExpertise/'.$cyberExpertise->expertise_code, [
                'expertise_code' => $faker->bothify('??#'),
                'description' => $faker->paragraph,
                'required_points' => $faker->numberBetween(0, 1000),
                '_token' => 'test'
            ]);
        $response->assertStatus(302)->assertRedirect('/cyberExpertise');
    }

    /**
     * Check redirect on attempt to delete CyberExpertise.
     */
    public function testCyberExpertiseDestroyDenied()
    {
        $user = factory(User::class)->create();
        $cyberExpertise = factory(CyberExpertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/cyberExpertise/'.$cyberExpertise->expertise_code);
        $response->assertStatus(403);
    }

    /**
     * Check controller delete CyberExpertise.
     */
    public function testCyberExpertiseDestroyIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $cyberExpertise = factory(CyberExpertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/cyberExpertise/'.$cyberExpertise->expertise_code);
        $response->assertStatus(302)->assertRedirect('/cyberExpertise');
        $this->assertEmpty(CyberExpertise::all());
    }

    /**
     * Check user can view other CyberExpertise.
     */
    public function testCyberExpertiseShow()
    {
        $user = factory(User::class)->create();
        $cyberExpertise = factory(CyberExpertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/cyberExpertise/'.$cyberExpertise->expertise_code);
        $response->assertStatus(200);
    }

    /**
     * Check user delete also removes Expertise(s) and PcePoint(s)
     */
    public function testCyberExpertiseDestroyRecursive()
    {
        $expertise = factory(Expertise::class)->create();
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->delete('/cyberExpertise/'.$expertise->cyberExpertise->expertise_code);
        $response->assertStatus(302)->assertRedirect('/cyberExpertise');
        $this->assertEmpty(CyberExpertise::all());
    }
}