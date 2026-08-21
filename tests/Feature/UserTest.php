<?php

namespace Tests\Feature;

use App\Models\Expertise;
use App\Models\PcePoint;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

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
     * Check the /users page.
     */
    public function testUserIndexUser()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get('/users');
        $response->assertStatus(200)->assertViewHas('users', [])->assertViewHas('q', '');
    }

    /**
     * Check the /users/search page.
     */
    public function testUserSearch()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post('/users/search');
        $response->assertStatus(302);
    }

    /**
     * A query matching nobody returns nothing.
     */
    public function testUserSearchQuery()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post(
                '/users/search',
                [
                    'q' => 'xyz',
                ]
            );
        $response->assertStatus(200)
            ->assertViewHas('q', 'xyz');
        $this->assertCount(0, $response->viewData('users'));
    }

    /**
     * An expert holding a valid registration is found by their cyber code.
     */
    public function testUserSearchQueryExact()
    {
        $user = User::factory()->create();
        Expertise::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(
                '/users/search',
                [
                    'q' => $user->cyber_code,
                ]
            );
        $response->assertStatus(200)
            ->assertViewHas('q', $user->cyber_code);
        $this->assertTrue($response->viewData('users')->contains('id', $user->id));
    }

    /**
     * Someone without any registration is not in the public register.
     */
    public function testUserSearchExcludesUserWithoutRegistration()
    {
        $searcher = User::factory()->create();
        $subject = User::factory()->create();

        $response = $this
            ->actingAs($searcher)
            ->post('/users/search', ['q' => $subject->cyber_code]);

        $response->assertStatus(200);
        $this->assertFalse($response->viewData('users')->contains('id', $subject->id));
    }

    /**
     * Someone whose registration has expired drops out of the register.
     */
    public function testUserSearchExcludesUserWithExpiredRegistration()
    {
        $searcher = User::factory()->create();
        $subject = User::factory()->create();
        Expertise::factory()->expired()->create(['user_id' => $subject->id]);

        $response = $this
            ->actingAs($searcher)
            ->post('/users/search', ['q' => $subject->cyber_code]);

        $response->assertStatus(200);
        $this->assertFalse($response->viewData('users')->contains('id', $subject->id));
    }

    /**
     * A name match still requires a valid registration, so the name filter
     * cannot leak past the registration check.
     */
    public function testUserSearchByNameStillRequiresValidRegistration()
    {
        $searcher = User::factory()->create();
        $subject = User::factory()->create(['last_name' => 'Rijbroek']);
        Expertise::factory()->expired()->create(['user_id' => $subject->id]);

        $response = $this
            ->actingAs($searcher)
            ->post('/users/search', ['q' => 'Rijbroek']);

        $response->assertStatus(200);
        $this->assertFalse($response->viewData('users')->contains('id', $subject->id));
    }

    /**
     * Only unexpired registrations are eager loaded for the result list.
     */
    public function testUserSearchOnlyLoadsValidRegistrations()
    {
        $searcher = User::factory()->create();
        $subject = User::factory()->create();
        Expertise::factory()->create(['user_id' => $subject->id]);
        Expertise::factory()->expired()->create(['user_id' => $subject->id]);

        $response = $this
            ->actingAs($searcher)
            ->post('/users/search', ['q' => $subject->cyber_code]);

        $found = $response->viewData('users')->firstWhere('id', $subject->id);
        $this->assertNotNull($found);
        $this->assertCount(1, $found->expertises);
        $this->assertTrue($found->expertises->first()->isValid);
    }

    /**
     * A search without a query is rejected rather than listing everyone.
     */
    public function testUserSearchRequiresQuery()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post('/users/search', []);

        $response->assertStatus(302)
            ->assertSessionHasErrors('q');
    }

    /**
     * The query has to be a string, which the previously malformed
     * 'required:string' rule did not enforce.
     */
    public function testUserSearchRejectsNonStringQuery()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post('/users/search', ['q' => ['an', 'array']]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('q');
    }

    /**
     * The expert page marks a valid registration.
     */
    public function testExpertShowMarksValidRegistration()
    {
        $user = User::factory()->create();
        Expertise::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('expert.show', ['user' => $user->cyber_code]));

        $response->assertStatus(200)
            ->assertSee('geregistreerd')
            ->assertSee('geldig tot');
    }

    /**
     * The expert page marks an expired registration as such.
     */
    public function testExpertShowMarksExpiredRegistration()
    {
        $user = User::factory()->create();
        Expertise::factory()->expired()->create(['user_id' => $user->id]);

        $response = $this->get(route('expert.show', ['user' => $user->cyber_code]));

        $response->assertStatus(200)
            ->assertSee('geen geldige registratie')
            ->assertSee('verlopen op');
    }

    /**
     * Check 200 page.
     */
    public function testUserCreate()
    {
        $user = User::factory()->create();
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
        $user = User::factory()->create();
        $password = $faker->password(12, 20);
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->post(
                '/users',
                [
                    'cyber_code'            => $faker->bothify('??##??'),
                    'first_name'            => $faker->firstName,
                    'middle_name'           => 'de',
                    'last_name'             => $faker->lastName,
                    'email'                 => $faker->email,
                    'date_of_birth'         => $faker->date(),
                    'place_of_birth'        => $faker->city,
                    'password'              => $password,
                    'password_confirmation' => $password,
                    '_token'                => 'test',
                ]
            );
        $response->assertStatus(302)->assertRedirect('/users');
        $this->assertCount(2, User::all());
    }

    /**
     * Check redirect on attempt to edit user.
     */
    public function testUserEditError()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
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
        $user = User::factory()->create();
        $user->is_controller = true;
        $userTwo = User::factory()->create();
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put(
                '/users/'.$userTwo->cyber_code,
                [
                    'cyber_code'     => $faker->bothify('??##??'),
                    'first_name'     => $faker->firstName,
                    'middle_name'    => 'de',
                    'last_name'      => $faker->lastName,
                    'email'          => $faker->email,
                    'date_of_birth'  => $faker->date(),
                    'place_of_birth' => $faker->city,
                    '_token'         => 'test',
                ]
            );
        $response->assertStatus(403);
    }

    /**
     * Check controller can edit user.
     */
    public function testUserUpdateIsController()
    {
        $user = User::factory()->create();
        $user->is_controller = true;
        $userTwo = User::factory()->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put(
                '/users/'.$userTwo->cyber_code,
                [
                    'cyber_code'     => $faker->bothify('??##??'),
                    'first_name'     => $faker->firstName,
                    'middle_name'    => 'de',
                    'last_name'      => $faker->lastName,
                    'email'          => $faker->email,
                    'date_of_birth'  => $faker->date(),
                    'place_of_birth' => $faker->city,
                    '_token'         => 'test',
                ]
            );
        $response->assertStatus(302)->assertRedirect('/users');
    }

    /**
     * Check user can edit own user.
     */
    public function testUserUpdateSelf()
    {
        $user = User::factory()->create();
        $faker = Factory::create();
        $response = $this
            ->actingAs($user)
            ->withSession(['_token' => 'test'])
            ->put(
                '/users/'.$user->cyber_code,
                [
                    'cyber_code'     => $faker->bothify('??##??'),
                    'first_name'     => $faker->firstName,
                    'middle_name'    => 'de',
                    'last_name'      => $faker->lastName,
                    'email'          => $faker->email,
                    'date_of_birth'  => $faker->date(),
                    'place_of_birth' => $faker->city,
                    '_token'         => 'test',
                ]
            );
        $response->assertStatus(302)->assertRedirect('/users');
    }

//    /**
//     * Check user can edit own user photo.
//     */
//    public function testUserUpdatePhoto()
//    {
//        $stub = __DIR__.'/user.jpg';
//        $name = Str::random(8).'.jpg';
//        $path = sys_get_temp_dir().'/'.$name;
//        copy($stub, $path);
//        $file = new UploadedFile($path, $name, 'image/jpeg', filesize($path), true);
//
//        $user = User::factory()->create();
//        $faker = Factory::create();
//        $response = $this
//            ->actingAs($user)
//            ->withSession(['_token' => 'test'])
//            ->put(
//                '/users/'.$user->cyber_code,
//                [
//                    'cyber_code'     => $faker->bothify('??##??'),
//                    'first_name'     => $faker->firstName,
//                    'middle_name'    => 'de',
//                    'last_name'      => $faker->lastName,
//                    'email'          => $faker->email,
//                    'date_of_birth'  => $faker->date(),
//                    'place_of_birth' => $faker->city,
//                    'file'           => $file,
//                    '_token'         => 'test',
//                ]
//            );
//        $response->assertStatus(302)->assertRedirect('/users');
//        $user = User::find($user->id);
//        $this->assertEquals(Image::make(__DIR__.'/user.jpg')->encode('data-url'), $user->photo);
//    }
//
//    /**
//     * Check user can't upload questionable content.
//     */
//    public function testUserUpdatePhotoNoImage()
//    {
//        $stub = __DIR__.'/UserTest.php';
//        $name = Str::random(8).'.jpg';
//        $path = sys_get_temp_dir().'/'.$name;
//        copy($stub, $path);
//        $file = new UploadedFile($path, $name, 'image/jpeg', filesize($path), true);
//
//        $user = User::factory()->create();
//        $faker = Factory::create();
//        $response = $this
//            ->actingAs($user)
//            ->withSession(['_token' => 'test'])
//            ->put(
//                '/users/'.$user->cyber_code,
//                [
//                    'cyber_code'     => $user->cyber_code,
//                    'first_name'     => $faker->firstName,
//                    'middle_name'    => 'de',
//                    'last_name'      => $faker->lastName,
//                    'email'          => $faker->email,
//                    'date_of_birth'  => $faker->date(),
//                    'place_of_birth' => $faker->city,
//                    'file'           => $file,
//                    '_token'         => 'test',
//                ]
//            );
//        $response->assertStatus(302)->assertRedirect('/users/'.$user->cyber_code.'/edit');
//        $user = User::find($user->id);
//        $this->assertNull($user->photo);
//    }

    /**
     * Check redirect on attempt to delete user.
     */
    public function testUserDestroyDenied()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
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
        $user = User::factory()->create();
        $user->is_controller = true;
        $userTwo = User::factory()->create();
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get('/users/'.$userTwo->cyber_code);
        $response->assertStatus(200);
    }

    /**
     * Check user delete also removes Expertise(s) and PcePoint(s).
     */
    public function testUserDestroyRecursive()
    {
        $user = User::factory()->create();
        $expertise = Expertise::factory()->create();
        $expertise->user()->associate($user);
        $expertise->save();
        $this->assertCount(1, Expertise::all());
        $pcePoint = new PcePoint();
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
