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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'headimgurl' => $faker->imageUrl(),
        'nickname' => $faker->userName,
        'phone' => $faker->phoneNumber,
        'user_last_login' => $faker->dateTime,
        'user_status' => $faker->randomDigit,
        'user_money' => $faker->randomDigit,
        'charging_total_cnt' => $faker->randomDigit,
        'charging_total_time' => $faker->randomDigit,
        'user_id' => $faker->unique()->buildingNumber,
        'openid' => $faker->randomLetter,
        'ip' => $faker->localIpv4,
    ];
});
