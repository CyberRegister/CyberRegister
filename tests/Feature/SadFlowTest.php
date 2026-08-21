<?php

namespace Tests\Feature;

use App\Models\CyberExpertise;
use App\Models\Expertise;
use App\Models\PcePoint;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use RuntimeException;
use Tests\TestCase;

/**
 * Covers the catch blocks in the resource controllers.
 *
 * Each of these redirects back to a form with the error attached. That
 * redirect is the part worth testing: it names a route parameter, and if it
 * names the wrong one the failure handler fails, turning a reportable problem
 * into a 500.
 */
class SadFlowTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * Make the next write of a model blow up.
     *
     * @param class-string $model
     * @param string       $event
     *
     * @return void
     */
    private function breakWrites(string $model, string $event): void
    {
        Event::listen(
            'eloquent.'.$event.': '.$model,
            function () {
                throw new RuntimeException('database is on fire');
            }
        );
    }

    /**
     * A controller who may edit everything.
     *
     * @return User
     */
    private function controller(): User
    {
        return User::factory()->create(['is_controller' => 1]);
    }

    /**
     * A failing user update is reported instead of crashing.
     */
    public function testUserUpdateFailureRedirectsWithError()
    {
        $user = $this->controller();
        $this->breakWrites(User::class, 'updating');

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/users/'.$user->cyber_code, [
                '_token'         => 'test',
                'cyber_code'     => $user->cyber_code,
                'first_name'     => 'Rian',
                'last_name'      => 'van Rijbroek',
                'date_of_birth'  => '1970-01-01',
                'place_of_birth' => 'Amsterdam',
                'email'          => 'rian@example.org',
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('users.edit', ['user' => $user]))
            ->assertSessionHasErrors();
    }

    /**
     * A failing user delete is reported instead of crashing.
     */
    public function testUserDeleteFailureRedirectsWithError()
    {
        $user = $this->controller();
        $victim = User::factory()->create();
        $this->breakWrites(User::class, 'deleting');

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->delete('/users/'.$victim->cyber_code, ['_token' => 'test']);

        $response->assertStatus(302)
            ->assertRedirect(route('users.edit', ['user' => $victim]))
            ->assertSessionHasErrors();
        $this->assertNotNull(User::find($victim->id));
    }

    /**
     * An unreadable upload is reported rather than stored.
     */
    public function testUserPhotoUploadFailureRedirectsWithError()
    {
        $user = $this->controller();

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/users/'.$user->cyber_code, [
                '_token'         => 'test',
                'cyber_code'     => $user->cyber_code,
                'first_name'     => 'Rian',
                'last_name'      => 'van Rijbroek',
                'date_of_birth'  => '1970-01-01',
                'place_of_birth' => 'Amsterdam',
                'email'          => 'rian@example.org',
                'file'           => UploadedFile::fake()->createWithContent('cv.txt', 'not an image at all'),
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('users.edit', ['user' => $user]))
            ->assertSessionHasErrors();
        $this->assertNull($user->refresh()->photo);
    }

    /**
     * A failing expertise update is reported instead of crashing.
     */
    public function testExpertiseUpdateFailureRedirectsWithError()
    {
        $user = $this->controller();
        $expertise = Expertise::factory()->create();
        $this->breakWrites(Expertise::class, 'updating');

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/expertise/'.$expertise->id, [
                '_token'                => 'test',
                'certification_code'    => 'ABC123',
                'date_of_certification' => '2020-01-01',
                'date_of_expiration'    => now()->addYear()->toDateString(),
                'user_id'               => $expertise->user_id,
                'cyber_expertise_id'    => $expertise->cyber_expertise_id,
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('expertise.edit', ['expertise' => $expertise]))
            ->assertSessionHasErrors();
    }

    /**
     * A failing expertise delete is reported instead of crashing.
     */
    public function testExpertiseDeleteFailureRedirectsWithError()
    {
        $user = $this->controller();
        $expertise = Expertise::factory()->create();
        $this->breakWrites(Expertise::class, 'deleting');

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->delete('/expertise/'.$expertise->id, ['_token' => 'test']);

        $response->assertStatus(302)
            ->assertRedirect(route('expertise.edit', ['expertise' => $expertise]))
            ->assertSessionHasErrors();
    }

    /**
     * A failing PCE point update is reported instead of crashing.
     */
    public function testPcePointUpdateFailureRedirectsWithError()
    {
        $user = $this->controller();
        $pcePoint = PcePoint::factory()->create();
        $this->breakWrites(PcePoint::class, 'updating');

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/pcePoint/'.$pcePoint->id, [
                '_token'        => 'test',
                'location_code' => 'AMS001',
                'points'        => 5,
                'user_id'       => $pcePoint->user_id,
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('pcePoint.edit', ['pcePoint' => $pcePoint]))
            ->assertSessionHasErrors();
    }

    /**
     * A failing PCE point delete is reported instead of crashing.
     */
    public function testPcePointDeleteFailureRedirectsWithError()
    {
        $user = $this->controller();
        $pcePoint = PcePoint::factory()->create();
        $this->breakWrites(PcePoint::class, 'deleting');

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->delete('/pcePoint/'.$pcePoint->id, ['_token' => 'test']);

        $response->assertStatus(302)
            ->assertRedirect(route('pcePoint.edit', ['pcePoint' => $pcePoint]))
            ->assertSessionHasErrors();
    }

    /**
     * A failing cyber expertise update is reported instead of crashing.
     */
    public function testCyberExpertiseUpdateFailureRedirectsWithError()
    {
        $user = $this->controller();
        $cyberExpertise = CyberExpertise::factory()->create();
        $this->breakWrites(CyberExpertise::class, 'updating');

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put('/cyberExpertise/'.$cyberExpertise->expertise_code, [
                '_token'          => 'test',
                'expertise_code'  => $cyberExpertise->expertise_code,
                'description'     => 'Iets met cyber',
                'required_points' => 10,
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('cyberExpertise.edit', ['cyberExpertise' => $cyberExpertise]))
            ->assertSessionHasErrors();
    }

    /**
     * A failing cyber expertise delete is reported instead of crashing.
     */
    public function testCyberExpertiseDeleteFailureRedirectsWithError()
    {
        $user = $this->controller();
        $cyberExpertise = CyberExpertise::factory()->create();
        $this->breakWrites(CyberExpertise::class, 'deleting');

        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->delete('/cyberExpertise/'.$cyberExpertise->expertise_code, ['_token' => 'test']);

        $response->assertStatus(302)
            ->assertRedirect(route('cyberExpertise.edit', ['cyberExpertise' => $cyberExpertise]))
            ->assertSessionHasErrors();
    }
}
