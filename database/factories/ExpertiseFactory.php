<?php

namespace Database\Factories;

use App\Models\CyberExpertise;
use App\Models\Expertise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expertise>
 */
class ExpertiseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Expertise>
     */
    protected $model = Expertise::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'            => User::factory(),
            'cyber_expertise_id' => CyberExpertise::factory(),
        ];
    }
}
