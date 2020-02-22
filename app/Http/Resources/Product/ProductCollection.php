<?php


// php artisan make:resource Product/ProductCollection






namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;//这里也是ResourceCollection

class ProductCollection extends Resource
            //改造了这里，本来是继承的R额sourceCollection，不知道是collection有什么区别，貌似也把数据全放在data里面了
            //因为用collection会打印整个类的很多信息，没用用
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [

                //            创建的时候默认写的是这样的
            //  return parent::toArray($request);

            //这个相当于拿来当过滤条件，本来返回一个$product完整的，但不想让别人看到多余的东西就用这个去过滤
            //就是在ProductController里面的全部show展示，而且都放在data里面了, 所以名字有个collection
            // 'secret' => $this->when($this->isAdmin(), 'secret-value'),  when方法可以筛选条件
            'name' => $this->name,
            'totalPrice' => round(( 1 - ($this->discount/100)) * $this->price,2),
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'discount' => $this->discount,
            'href' => [
                'link' => route('products.show',$this->id)
            ]
        ];
    }
}
