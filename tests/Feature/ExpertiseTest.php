<?php

namespace Tests\Feature;

use App\Models\CyberExpertise;
use App\Models\Expertise;
use App\Models\User;
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
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
                    'cyber_expertise_id'    => CyberExpertise::factory()->create()->id,
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
        $user = User::factory()->create();
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
                    'cyber_expertise_id'    => CyberExpertise::factory()->create()->id,
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
        $user = User::factory()->create();
        $expertise = Expertise::factory()->create();
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
        $user = User::factory()->create();
        $user->is_controller = true;
        $expertise = Expertise::factory()->create();
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
        $user = User::factory()->create();
        $expertise = Expertise::factory()->create();
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
                    'cyber_expertise_id'    => CyberExpertise::factory()->create()->id,
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
        $user = User::factory()->create();
        $user->is_controller = true;
        $expertise = Expertise::factory()->create();
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
                    'cyber_expertise_id'    => CyberExpertise::factory()->create()->id,
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
        $user = User::factory()->create();
        $expertise = Expertise::factory()->create();
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
        $user = User::factory()->create();
        $user->is_controller = true;
        $expertise = Expertise::factory()->create();
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
        $user = User::factory()->create();
        $expertise = Expertise::factory()->create();
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
        $expertise = Expertise::factory()->create();
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
        $user = User::factory()->create();
        $user->is_controller = true;
        $expertise = Expertise::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get('/expertise/'.$expertise->id);
        $response->assertStatus(200);
    }
}
