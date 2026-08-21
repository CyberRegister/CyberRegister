<?php

namespace Database\Factories;

use App\Models\CyberExpertise;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            // expertise_code is unique in the schema, on a case insensitive
            // collation, so 'abc' and 'ABC' collide in the database even
            // though Faker considers them distinct. Restricting the alphabet
            // to a single case makes uniqueness here mean uniqueness there.
            'expertise_code'  => $this->faker->unique()->regexify('[A-Z0-9]{3}'),
            'required_points' => $this->faker->numberBetween(1, 999),
            'description'     => $this->faker->paragraph(),
        ];
    }
}
