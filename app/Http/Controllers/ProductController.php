<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function __construct()
    {
        //增加了一个api验证，就是用passport那个地方改的这儿，修改，删除都需要验证身份，除了下面这两个页面不用
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //用这个过滤后的resource，如果像下面用new ProductCollection就会出现只能用一次的情况，所以改成collection
        //用paginate可以直接把meta和link都加在json最下面
        //两个resource的建立是为了一个index就是collection很多
        return ProductCollection::collection(Product::paginate(20));
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
    public function store(ProductRequest $request)//这个类名本来是$Request要相应的修改
    {

        //可以用create方法吗？感觉应该可以只要改fill那儿，还没试
        $product = new Product;
        $product->name = $request->name;
        $product->detail = $request->description;//只需要对应数据库里的detail就是现在传来的description
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->save();
        return response([
            //用之前改造的类来接收,use Symfony\Component\HttpFoundation\Response; 这个下面有所有404代码，HTTP_CREATED
            //只是里面的一个自己去选的
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED);
        //Symfony\Component\HttpFoundation\Response; 所有的response返回值都在这儿去对应
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //用过滤后的resource，而且这边是展示个例，就用单个的不是：：Collection
        //打印很多个就是collection比如上面index是展示所有的不止一个
        
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //这个方法在最下面
        $this->ProductUserCheck($product);

        $request['detail'] = $request->description;//这一步是因为他视频里描述改变了
        unset($request['description']);

        //可以打印下$product是旧数据，$request是新数据
        $product->update($request->all());
        return response([
            //又用前面的自选resource重新格式化一下选自己需要的schema
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->ProductUserCheck($product);
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }

    public function ProductUserCheck($product)
    {
        if (Auth::id() !== $product->user_id) {
            throw new ProductNotBelongsToUser;
        }
    }
}
