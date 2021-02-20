<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->numberBetween($min=1, $max=10000),
        'tweet' => $faker->realText(10),
        'introduction' => $faker->realText($maxNbChars=100, $indexSize=3),
        'hobby' => $faker->text(10),
        'blood_type' => 'B',
        'job' => $faker->jobTitle(),
        'image_name' => 'no_image.png'
    ];
});
