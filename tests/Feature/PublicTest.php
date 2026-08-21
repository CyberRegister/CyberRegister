<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PublicTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     */
    public function testWelcome()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * The front page counts sign-ups from the past month, not the ones
     * before it.
     */
    public function testWelcomeCountsRecentSignups()
    {
        User::factory()->create(['created_at' => Carbon::now()->subDays(3)]);
        User::factory()->create(['created_at' => Carbon::now()->subMonths(6)]);

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('afgelopen maand reeds 1 nieuwe experts');
    }

    /**
     * Check redirect to /login when going to the /home page.
     */
    public function testHomeRedirect()
    {
        $response = $this->get('/home');
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * Check JSON request Unauthenticated . .
     */
    public function testJsonRedirect()
    {
        $response = $this->json('GET', '/home');
        $response->assertStatus(401)
            ->assertExactJson(['message' => 'Unauthenticated.']);
    }
}
