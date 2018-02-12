<?php
namespace Tests\Unit;
use App\CyberExpertise;
use App\User;
use App\Expertise;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CyberExpertiseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assert CyberExpertise might have a relation with multiple App\Expertise(s)
     */
    public function testCyberExpertiseHasExpertiseRelation() {
        $expertise = factory(Expertise::class)->create();
        $expertise->cyberExpertise->save();
        $expertise->save();
        $this->assertCount(1, $expertise->cyberExpertise->expertises);
        $secondExpertise = factory(Expertise::class)->create();
        $secondExpertise->cyberExpertise()->associate($expertise->cyberExpertise->id);
        $secondExpertise->save();
        $expertise = Expertise::find($expertise->id);
        $this->assertCount(2, $expertise->cyberExpertise->expertises);
    }
}