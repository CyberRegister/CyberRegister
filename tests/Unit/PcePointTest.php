<?php

namespace Tests\Unit;

use App\Models\PcePoint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PcePointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assert the PcePoint might have a relation with a single App\Models\User.
     */
    public function testPcePointHasUserRelation()
    {
        $point = new PcePoint();
        $this->assertNull($point->user);

        $user = User::factory()->create();
        $point->user()->associate($user);
        $this->assertInstanceOf('App\Models\User', $point->user);
    }
}
