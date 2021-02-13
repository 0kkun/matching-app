<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->randumNumber(3), // 3桁のランダム数値
        'tweet' => $faker->realText(50),
        'introduction' => $faker->realText($maxNbChars = 100,$indexSize = 3),
        'hobby' => $faker->text(10),
        'blood_type' => 'B',
        'job' => $faker->jobTitle()
    ];
});
