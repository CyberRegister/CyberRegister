<?php

namespace Tests\Feature;

use App\PcePoint;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PcePointTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * Check redirect to /login when going to the /pcePoint page.
     */
    public function testPcePointHomeRedirect()
    {
        $response = $this->get('/pcePoint');
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * Check JSON request Unauthenticated . .
     */
    public function testPcePointJsonRedirect()
    {
        $response = $this->json('GET', '/pcePoint');
        $response->assertStatus(401)
            ->assertExactJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Check 200.
     */
    public function testPcePointIndex()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/pcePoint');
        $response->assertStatus(403);
    }

    /**
     * Check 200.
     */
    public function testPcePointIndexIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->get('/pcePoint');
        $response->assertStatus(200)->assertViewHas('pcePoints', PcePoint::all());
    }

    /**
     * Check 403 page.
     */
    public function testPcePointCreate()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/pcePoint/create');
        $response->assertStatus(403);
    }

    /**
     * Check 200 page.
     */
    public function testPcePointCreateIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->get('/pcePoint/create');
        $response->assertStatus(200);
    }

    /**
     * Check user creation.
     */
    public function testPcePointStore()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->post(
                '/pcePoint', [
                'location_code' => $faker->bothify('??##??'),
                'user_id'       => $user->id,
                'points'        => $faker->numberBetween(0, 1000),
                '_token'        => 'test',
                ]
            );
        $response->assertStatus(403);
    }

    /**
     * Check user cyber.
     */
    public function testPcePointStoreIsController()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->post(
                '/pcePoint', [
                'location_code' => $faker->bothify('??##??'),
                'user_id'       => $user->id,
                'points'        => $faker->numberBetween(0, 1000),
                '_token'        => 'test',
                ]
            );
        $response->assertStatus(302)->assertRedirect('/pcePoint');
        $this->assertCount(1, PcePoint::all());
    }

    /**
     * Check redirect on attempt to edit PcePoint.
     */
    public function testPcePointEditError()
    {
        $user = factory(User::class)->create();
        $pcePoint = factory(PcePoint::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/pcePoint/'.$pcePoint->id.'/edit');
        $response->assertStatus(403);
    }

    /**
     * Check controller can get edit view for PcePoint.
     */
    public function testPcePointEditIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $pcePoint = factory(PcePoint::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/pcePoint/'.$pcePoint->id.'/edit');
        $response->assertStatus(200);
    }

    /**
     * Check redirect on attempt to edit PcePoint.
     */
    public function testPcePointUpdateDenied()
    {
        $user = factory(User::class)->create();
        $pcePoint = factory(PcePoint::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put(
                '/pcePoint/'.$pcePoint->id, [
                'location_code' => $faker->bothify('??##??'),
                'user_id'       => $user->id,
                'points'        => $faker->numberBetween(0, 1000),
                '_token'        => 'test',
                ]
            );
        $response->assertStatus(403);
    }

    /**
     * Check controller can edit PcePoint.
     */
    public function testPcePointUpdateIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $pcePoint = factory(PcePoint::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put(
                '/pcePoint/'.$pcePoint->id, [
                'location_code' => $faker->bothify('??##??'),
                'user_id'       => $user->id,
                'points'        => $faker->numberBetween(0, 1000),
                '_token'        => 'test',
                ]
            );
        $response->assertStatus(302)->assertRedirect('/pcePoint');
    }

    /**
     * Check redirect on attempt to delete PcePoint.
     */
    public function testPcePointDestroyDenied()
    {
        $user = factory(User::class)->create();
        $pcePoint = factory(PcePoint::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/pcePoint/'.$pcePoint->id);
        $response->assertStatus(403);
    }

    /**
     * Check controller delete PcePoint.
     */
    public function testPcePointDestroyIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $pcePoint = factory(PcePoint::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/pcePoint/'.$pcePoint->id);
        $response->assertStatus(302)->assertRedirect('/pcePoint');
        $this->assertEmpty(PcePoint::all());
    }

    /**
     * Check user can view other PcePoint.
     */
    public function testPcePointShow()
    {
        $user = factory(User::class)->create();
        $pcePoint = factory(PcePoint::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/pcePoint/'.$pcePoint->id);
        $response->assertStatus(403);
    }

    /**
     * Check user can view own PcePoint.
     */
    public function testExpertiseShowOwn()
    {
        $pcePoint = factory(PcePoint::class)->create();
        $response = $this
            ->actingAs($pcePoint->user)
            ->get('/pcePoint/'.$pcePoint->id);
        $response->assertStatus(200);
    }

    /**
     * Check controller can view other PcePoint.
     */
    public function testExpertiseShowIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $pcePoint = factory(PcePoint::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/pcePoint/'.$pcePoint->id);
        $response->assertStatus(200);
    }
}
