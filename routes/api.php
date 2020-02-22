<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//api加上这三个字，就不会产生delete，create，的route
Route::apiResource('/products','ProductController');
Route::group(['prefix'=>'products'],function(){
	Route::apiResource('/{product}/reviews','ReviewController');
});
