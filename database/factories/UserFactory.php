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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        //如果不自己注册一个user，数据库最开始产生的user不知道乱的密码到底是什么，其实就是这个！
        'password' => $password ?: $password = bcrypt('secret'),//这个要影响passport在postman里面的使用
        //第十分钟   https://www.udemy.com/course/laravel-e-commerce-restful-api/learn/lecture/9251062#overview
        'remember_token' => str_random(10),
    ];
});
