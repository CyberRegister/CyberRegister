<?php

namespace Tests\Unit;

use App\Models\CyberExpertise;
use App\Models\Expertise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CyberExpertiseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assert CyberExpertise might have a relation with multiple App\Models\Expertise(s).
     */
    public function testCyberExpertiseHasExpertiseRelation()
    {
        $expertise = Expertise::factory()->create();
        $expertise->cyberExpertise->save();
        $expertise->save();
        $this->assertCount(1, $expertise->cyberExpertise->expertises);
        $secondExpertise = Expertise::factory()->create();
        $secondExpertise->cyberExpertise()->associate($expertise->cyberExpertise->id);
        $secondExpertise->save();
        $expertise = Expertise::find($expertise->id);
        $this->assertCount(2, $expertise->cyberExpertise->expertises);
    }
}
