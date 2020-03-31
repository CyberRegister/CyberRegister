<?php

namespace Tests\Feature;

use App\CyberExpertise;
use App\Expertise;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExpertiseTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * Check redirect to /login when going to the /expertise page.
     */
    public function testExpertiseHomeRedirect()
    {
        $response = $this->get('/expertise');
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * Check JSON request Unauthenticated . .
     */
    public function testExpertiseJsonRedirect()
    {
        $response = $this->json('GET', '/expertise');
        $response->assertStatus(401)
            ->assertExactJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Check 403.
     */
    public function testExpertiseIndex()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/expertise');
        $response->assertStatus(403);
    }

    /**
     * Check 200.
     */
    public function testExpertiseIndexIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->get('/expertise');
        $response->assertStatus(200)->assertViewHas('expertises', Expertise::all());
    }

    /**
     * Check 403 page.
     */
    public function testExpertiseCreate()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/expertise/create');
        $response->assertStatus(403);
    }

    /**
     * Check 200 page.
     */
    public function testExpertiseCreateIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->get('/expertise/create');
        $response->assertStatus(200);
    }

    /**
     * Check user creation.
     */
    public function testExpertiseStore()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->post(
                '/expertise',
                [
                    'certification_code'    => $faker->bothify('??##??'),
                    'date_of_certification' => $faker->date(),
                    'date_of_expiration'    => $faker->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
                    'user_id'               => $user->id,
                    'cyber_expertise_id'    => factory(CyberExpertise::class)->create()->id,
                    '_token'                => 'test',
                ]
            );
        $response->assertStatus(403);
    }

    /**
     * Check user cyber.
     */
    public function testExpertiseStoreIsController()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->post(
                '/expertise',
                [
                    'certification_code'    => $faker->bothify('??##??'),
                    'date_of_certification' => $faker->date(),
                    'date_of_expiration'    => $faker->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
                    'user_id'               => $user->id,
                    'cyber_expertise_id'    => factory(CyberExpertise::class)->create()->id,
                    '_token'                => 'test',
                ]
            );
        $response->assertStatus(302)->assertRedirect('/expertise');
        $this->assertCount(1, Expertise::all());
    }

    /**
     * Check redirect on attempt to edit Expertise.
     */
    public function testExpertiseEditError()
    {
        $user = factory(User::class)->create();
        $expertise = factory(Expertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/expertise/'.$expertise->id.'/edit');
        $response->assertStatus(403);
    }

    /**
     * Check controller can get edit view for Expertise.
     */
    public function testExpertiseEditIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $expertise = factory(Expertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/expertise/'.$expertise->id.'/edit');
        $response->assertStatus(200);
    }

    /**
     * Check redirect on attempt to edit Expertise.
     */
    public function testExpertiseUpdateDenied()
    {
        $user = factory(User::class)->create();
        $expertise = factory(Expertise::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put(
                '/expertise/'.$expertise->id,
                [
                    'certification_code'    => $faker->bothify('??##??'),
                    'date_of_certification' => $faker->date(),
                    'date_of_expiration'    => $faker->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
                    'user_id'               => $user->id,
                    'cyber_expertise_id'    => factory(CyberExpertise::class)->create()->id,
                    '_token'                => 'test',
                ]
            );
        $response->assertStatus(403);
    }

    /**
     * Check controller can edit Expertise.
     */
    public function testExpertiseUpdateIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $expertise = factory(Expertise::class)->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put(
                '/expertise/'.$expertise->id,
                [
                    'certification_code'    => $faker->bothify('??##??'),
                    'date_of_certification' => $faker->date(),
                    'date_of_expiration'    => $faker->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
                    'user_id'               => $user->id,
                    'cyber_expertise_id'    => factory(CyberExpertise::class)->create()->id,
                    '_token'                => 'test',
                ]
            );
        $response->assertStatus(302)->assertRedirect('/expertise');
    }

    /**
     * Check redirect on attempt to delete Expertise.
     */
    public function testExpertiseDestroyDenied()
    {
        $user = factory(User::class)->create();
        $expertise = factory(Expertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/expertise/'.$expertise->id);
        $response->assertStatus(403);
    }

    /**
     * Check controller delete Expertise.
     */
    public function testExpertiseDestroyIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $expertise = factory(Expertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->delete('/expertise/'.$expertise->id);
        $response->assertStatus(302)->assertRedirect('/expertise');
        $this->assertEmpty(Expertise::all());
    }

    /**
     * Check user can view other Expertise.
     */
    public function testExpertiseShow()
    {
        $user = factory(User::class)->create();
        $expertise = factory(Expertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/expertise/'.$expertise->id);
        $response->assertStatus(403);
    }

    /**
     * Check user can view own Expertise.
     */
    public function testExpertiseShowOwn()
    {
        $expertise = factory(Expertise::class)->create();
        $response = $this
            ->actingAs($expertise->user)
            ->get('/expertise/'.$expertise->id);
        $response->assertStatus(200);
    }

    /**
     * Check controller can view other Expertise.
     */
    public function testExpertiseShowIsController()
    {
        $user = factory(User::class)->create();
        $user->is_controller = true;
        $expertise = factory(Expertise::class)->create();
        $response = $this
            ->actingAs($user)
            ->get('/expertise/'.$expertise->id);
        $response->assertStatus(200);
    }
}
