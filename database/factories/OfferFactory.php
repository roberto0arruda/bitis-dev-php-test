<?php

/** @var Factory $factory */

use App\Models\Offer;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Offer::class, function (Faker $faker) {
    $dt = $faker->dateTimeBetween('now', '+15 days');

    return [
        'name' => $faker->word,
        'discount_percentage' => $faker->numberBetween(5, 75),
        'expired_at' => $dt->format('Y-m-d')
    ];
});
