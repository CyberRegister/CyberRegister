<?php
namespace Tests\Unit;
use App\User;
use App\Expertise;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserExpertiseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Assert the UserExpertise might have a relation with a single App\User
     */
    public function testUserExpertiseHasUserRelation() {
        $userExpertise = new Expertise;
        $this->assertNull($userExpertise->user);

        $user = factory(User::class)->create();
        $userExpertise->user()->associate($user);
        $this->assertInstanceOf('App\User', $userExpertise->user);
    }

}