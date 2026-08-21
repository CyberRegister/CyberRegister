<?php

namespace Database\Factories;

use App\Models\CyberExpertise;
use App\Models\Expertise;
use App\Models\User;
use Carbon\Carbon;
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
            'user_id'               => User::factory(),
            'cyber_expertise_id'    => CyberExpertise::factory(),
            'date_of_certification' => Carbon::today()->subYear(),
            'date_of_expiration'    => Carbon::today()->addYear(),
        ];
    }

    /**
     * A registration whose expiry date has passed.
     *
     * @return static
     */
    public function expired(): static
    {
        return $this->state(
            fn (array $attributes) => [
                'date_of_certification' => Carbon::today()->subYears(3),
                'date_of_expiration'    => Carbon::today()->subDay(),
            ]
        );
    }
}
