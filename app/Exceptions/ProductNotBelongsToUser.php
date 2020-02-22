<?php

namespace App\Exceptions;

use Exception;


//这个exception是用来屏蔽如果不是product的创造者，不能修改
//用在了ProductController下面的update里面
class ProductNotBelongsToUser extends Exception
{
    public function render()
    {
    	return ['errors' => 'Product Not Belongs to User'];
    }
}
