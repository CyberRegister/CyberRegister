<?php

namespace Tests\Unit;

use App\PcePoint;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PcePointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assert the PcePoint might have a relation with a single App\User.
     */
    public function testPcePointHasUserRelation()
    {
        $point = new PcePoint();
        $this->assertNull($point->user);

        $user = factory(User::class)->create();
        $point->user()->associate($user);
        $this->assertInstanceOf('App\User', $point->user);
    }
}
