<?php

namespace Tests\Unit;

use App\Models\CyberExpertise;
use App\Models\Expertise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpertiseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assert the Expertise might have a relation with a single App\Models\User.
     */
    public function testExpertiseHasUserRelation()
    {
        $expertise = new Expertise();
        $this->assertNull($expertise->user);

        $user = User::factory()->create();
        $expertise->user()->associate($user);
        $this->assertInstanceOf('App\Models\User', $expertise->user);
    }

    /**
     * Assert the Expertise might have a relation with a single App\Models\CyberExpertise.
     */
    public function testExpertiseHasCyberExpertiseRelation()
    {
        $expertise = new Expertise();
        $this->assertNull($expertise->cyberExpertise);

        $cyberExpertise = new CyberExpertise();
        $expertise->cyberExpertise()->associate($cyberExpertise);
        $this->assertInstanceOf('App\Models\CyberExpertise', $expertise->cyberExpertise);
    }

    /**
     * Assert the Expertise can get code from App\Models\CyberExpertise.
     */
    public function testExpertiseHasCodeViaCyberExpertiseRelation()
    {
        $expertise = new Expertise();
        $this->assertEquals('', $expertise->expertise_code);

        $cyberExpertise = CyberExpertise::factory()->create();
        $cyberExpertise->save();
        $expertise->cyberExpertise()->associate($cyberExpertise);
        $this->assertEquals($cyberExpertise->expertise_code, $expertise->code);
    }
}
