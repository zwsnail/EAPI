<?php

namespace App\Exceptions;

use App\Exceptions\ExceptionTrait;
use Exception;
//上面两条是用的老师自建的

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


class Handler extends ExceptionHandler
{
    use ExceptionTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        //这个if是新添加的，因为判断的时候post，update里面都是写的accept type是json
        //如果把Accept那里打钩的地方去掉，会显示一个安全的laravel自带的html就是安全的，
        //没必要改就用下面parent那个默认的render就可以了

        //Hand the exceptions
        //这里是用来显示错误信息的，以免把所有错误点（其实也还是只捕捉了那两项错误1.route不对，2。model输入id根本没有）
        //都显示给客户看到很多被攻击的地方
        if ($request->expectsJson()) {
            return $this->apiException($request,$exception);
            //这个apiException是老师自己在上面那个ExceptionTrait写的这个方法
            //为的是不要所有的逻辑都在一起，不符合一个类一个功能的设计原则
        }
        return parent::render($request, $exception);
    }
}
