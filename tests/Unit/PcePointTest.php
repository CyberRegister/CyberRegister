<?php
namespace Tests\Unit;
use App\PcePoint;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PcePointTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Assert the order coupon might have a relation with a single App\Models\Order
     */
    public function testPcePointHasUserRelation() {
        $point = new PcePoint;
        $this->assertNull($point->user);

        $user = factory(User::class)->create();
        $point->user()->associate($user);
        $this->assertInstanceOf('App\User', $point->user);
    }

}