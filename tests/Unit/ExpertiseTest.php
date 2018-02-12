<?php
namespace Tests\Unit;
use App\CyberExpertise;
use App\User;
use App\Expertise;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpertiseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assert the Expertise might have a relation with a single App\User
     */
    public function testExpertiseHasUserRelation() {
        $expertise = new Expertise;
        $this->assertNull($expertise->user);

        $user = factory(User::class)->create();
        $expertise->user()->associate($user);
        $this->assertInstanceOf('App\User', $expertise->user);
    }

    /**
     * Assert the Expertise might have a relation with a single App\CyberExpertise
     */
    public function testExpertiseHasCyberExpertiseRelation() {
        $expertise = new Expertise;
        $this->assertNull($expertise->cyberExpertise);

        $cyberExpertise = new CyberExpertise;
        $expertise->cyberExpertise()->associate($cyberExpertise);
        $this->assertInstanceOf('App\CyberExpertise', $expertise->cyberExpertise);
    }

    /**
     * Assert the Expertise can get code from App\CyberExpertise
     */
    public function testExpertiseHasCodeViaCyberExpertiseRelation()
    {
        $expertise = new Expertise;
        $this->assertEquals('', $expertise->expertise_code);

        $cyberExpertise = factory(CyberExpertise::class)->create();;
        $cyberExpertise->save();
        $expertise->cyberExpertise()->associate($cyberExpertise);
        $this->assertEquals($cyberExpertise->expertise_code, $expertise->code);
    }
}