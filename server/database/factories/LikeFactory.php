<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Like;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'request_user_id' => $faker->numberBetween($min=1, $max=10000),
        'receive_user_id' => $faker->numberBetween($min=1, $max=10000),
        'is_matched' => false,
    ];
});
