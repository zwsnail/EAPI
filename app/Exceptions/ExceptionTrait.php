<?php

//这里是全部手建的，没有用artisan为的是能处理通用的所有exception而不是就之前那两个
namespace App\Exceptions;

//下面这两条本来是在Handler.php里面，因为在这里处理，所有手动把它们移过来了
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ExceptionTrait
{	
	//其他方法都是protected因为对外只用这个方法
	public function apiException($request,$e)
	{
			if ($this->isModel($e)) {
                return $this->ModelResponse($e);
            }
			//这里http的意思就是route万一乱写一个找不到，
			//所有实际上不是json的错误，laravel都有自带的错误保护页面，这里不需要来处理
			if ($this->isHttp($e)) {
				return $this->HttpResponse($e);
			}
			
			//这个是我update的时候用了post方法，而不是put时候自己发现的
			if ($this->isMethod($e)) {
				return $this->MethodResponse($e);
			}
				
			//下面这句话的意思是如果捕捉不了这两种，其他的就用下面这个默认处理
			//这句话是默认的，handler里面也用这句
				return parent::render($request, $e);

	}

	//这个方法纯粹是为了让上面那里显得不那么臃肿
	protected function isModel($e)
	{
		return $e instanceof ModelNotFoundException;
	}
    //同上
	protected function isHttp($e)
	{
		return $e instanceof NotFoundHttpException; 
	}

	protected function isMethod($e)
	{
		return $e instanceof MethodNotAllowedHttpException; //记住要去引用class
	}
    //也是感觉可以“提取公英式”一样为了让第一个方法不那么臃肿
	protected function ModelResponse($e)
	{
		return response()->json([
                    'errors' => 'Product Model not found'
                ],Response::HTTP_NOT_FOUND);
	}

	protected function HttpResponse($e)
	{
		return response()->json([
                    'errors' => 'Incorect route'
                ],Response::HTTP_NOT_FOUND);
	}

	protected function MethodResponse($e)
	{
		return response()->json([
                    'errors' => 'Method Not Allowed'
                ],Response::HTTP_NOT_FOUND);
	}

	
}