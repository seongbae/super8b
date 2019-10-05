<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Workout;
use Faker\Generator as Faker;

$factory->define(Workout::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'user_id' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
