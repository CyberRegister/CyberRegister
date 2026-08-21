<?php

namespace Database\Factories;

use App\Models\PcePoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PcePoint>
 */
class PcePointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<PcePoint>
     */
    protected $model = PcePoint::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'points'  => $this->faker->numberBetween(1, 999),
        ];
    }
}
