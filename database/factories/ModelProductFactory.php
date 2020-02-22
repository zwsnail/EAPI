<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Model\Product::class, function (Faker $faker) {
    return [
        //这里是在faker library GitHub上面的一个项目搜索找到运用方法的

        'name' => $faker->word,
        'detail' => $faker->paragraph,
        'price' => $faker->numberBetween(100,1000),
        'stock'=> $faker->randomDigit,
        'discount' => $faker->numberBetween(2,30),
        'user_id' => function(){
        	return App\User::all()->random();
        },
    ];
});
