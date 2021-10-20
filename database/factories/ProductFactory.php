<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->city . ' ' . $faker->lastName,
        'description' => $faker->text,
        'price' => $faker->numberBetween(1000, 100000),
    ];
});
