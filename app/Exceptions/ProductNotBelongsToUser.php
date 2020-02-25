<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;


//这个exception是用来屏蔽如果不是product的创造者，不能修改
//用在了ProductController下面的update里面
class ProductNotBelongsToUser extends Exception
{
    public function render()
    {
        return response([
            ['errors' => 'Product Not Belongs to User']
        ],Response::HTTP_FORBIDDEN);

        //老师的，上面是我改造的
    	return ['errors' => 'Product Not Belongs to User'];
    }
}
