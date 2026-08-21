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
     * The front page carries the register description agreed in #19.
     */
    public function testWelcomeShowsRegisterDescription()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('openbaar register van gecertificeerde cyberexperts')
            ->assertSee('alleen geldige expertises doorzoekbaar');
    }

    /**
     * The registration form explains what happens to the data, per #20.
     */
    public function testRegisterShowsDataNotice()
    {
        $response = $this->get('/register');

        $response->assertStatus(200)
            ->assertSee('openbaar doorzoekbare cyberregister')
            ->assertSee('het recht om vergeten te worden')
            ->assertSee('zodra u besluit forwarding aan te zetten');
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
