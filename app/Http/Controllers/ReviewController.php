<?php

namespace App\Http\Controllers;

use App\Model\Review;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ReviewResourceShow;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //collection就是因为这个是查询很多个，一个product下面会有很多个review
        return ReviewResource::collection($product->reviews);
        //知道是基于hasMany但是想不通为什么不是reviews()
        //不知道是不是这个意思现在还没懂anyway
        //https://xueyuanjun.com/link/19930#bkmrk-%E9%80%9A%E8%BF%87%E5%8A%A8%E6%80%81%E5%B1%9E%E6%80%A7%E8%8E%B7%E5%8F%96%E8%BE%93%E5%85%A5
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request,Product $product)
    {
        //只要store就要定规则，定规则就去新建resource，resource里面有rulls
        //php artisan make:resource ReviewResource

        //可以先return那两个参数出来看看
        $review = new Review($request->all());
        //因为是关联数组，所以必须把参数加上product，已经有hasMany,所以可以->reviews()
        $product->reviews()->save($review);
        return response([
            'data' => new ReviewResource($review)
        ],Response::HTTP_CREATED);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Review $review)
    {
        //我添加的这里，视频里没加这部
 
        // return $product->id;
        // return $review;
        // return new ReviewResource($product->reviews);
        $review_id = $review->id;
        $o = Review::find($review_id);
        return new ReviewResourceShow($o);
        //我靠试了我多久啊，两三个小时过了都不知道resource里面的参数到底是什么！？
        //其实就是一个将被转化成数组的集合！！！所以只要给集合就OK！！！
        return new ReviewResourceShow(Review::find($product->id));
        return new ReviewResourceShow($product->reviews);//date[]
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product, Review $review)
    {
        $review->update($request->all());
        return response([
            'data' => new ReviewResource($review)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Review $review)
    {
        $review->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
