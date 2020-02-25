<?php

namespace App\Model;

use App\User;
use App\Model\Review;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		//这里没有user_id因为这个api是APIResource不需要create，
		//所以新建的user里面不会在products那个表里生成user_id，而是通过的factory随机产生的
		'name','detail','stock','price','discount'
	];
    public function reviews()
    {
    	return $this->hasMany(Review::class); 
	}
	
	//这个是我改造的
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
