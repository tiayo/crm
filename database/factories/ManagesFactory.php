<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Model\Manager::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->unique()->name,
        'email'          => $faker->unique()->safeEmail,
        'type'           => $faker->numberBetween(0, 99),
        'group'          => $faker->numberBetween(0, 99),
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
