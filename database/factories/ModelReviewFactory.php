<?php


use App\Model\Product;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Model\Review::class, function (Faker $faker) {
    return [
        //可以在文档factory下面找到用法
    	'product_id' => function(){
    		return Product::all()->random();	
    	},
        'customer' => $faker->name,
        'review' => $faker->paragraph,
        'star' => $faker->numberBetween(0,5)
    ];
});
