<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            //这个相当于拿来当过滤条件，本来返回一个$product完整的，但不想让别人看到多余的东西就用这个去过滤
            //就是在ProductController里面的单个index展示
            //还可以添加没有的项目，比如那个totalPrice在表里面是没有这行的，简单计算就可以得到

            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
            'stock' => $this->stock == 0 ? 'Out of Stock' : $this->stock,
            'discount' =>$this->discount,
            'totalPrice' => round(( 1 - ($this->discount/100)) * $this->price,2),
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'href' => [
                //这个地方要结合php artisan route:list 来看
                'reviews' => route('reviews.index',$this->id)
            ]
        ];
    }
}
