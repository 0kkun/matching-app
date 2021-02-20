<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Message;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'send_user_id' => $faker->numberBetween($min=1, $max=10000),
        'receive_user_id' => $faker->numberBetween($min=1, $max=10000),
        'message' => $faker->realText($maxNbChars = 100, $indexSize = 3),
    ];
});
