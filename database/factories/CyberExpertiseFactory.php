<?php

namespace Database\Factories;

use App\Models\CyberExpertise;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CyberExpertise>
 */
class CyberExpertiseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CyberExpertise>
     */
    protected $model = CyberExpertise::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expertise_code'  => Str::random(3),
            'required_points' => $this->faker->numberBetween(1, 999),
            'description'     => $this->faker->paragraph(),
        ];
    }
}
