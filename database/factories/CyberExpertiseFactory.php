<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(
    App\CyberExpertise::class,
    function (Faker $faker) {
        return [
            'expertise_code'  => str_random(3),
            'required_points' => $faker->randomDigit(3),
            'description'     => $faker->paragraph,
        ];
    }
);
