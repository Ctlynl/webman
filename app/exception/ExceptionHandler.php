<?php

namespace app\exception;

use app\support\ApiResponse;
use Throwable;
use Tinywan\Validate\Exception\ValidateException;
use Webman\Http\Request;
use Webman\Http\Response;

class ExceptionHandler extends \Webman\Exception\ExceptionHandler
{
    public $dontReport = [
        AppException::class,
        ValidateException::class
    ];

    public function render(Request $request, Throwable $exception): Response
    {
        if ($exception instanceof AppException) {
            $response = ApiResponse::errorByAppException($exception);
        } elseif ($exception instanceof ValidateException) {
            $response = ApiResponse::errorByValidateException($exception);
        } elseif ($request->expectsJson()) {
            $body = [];
            $this->debug && $body['traces'] = $exception->getMessage() . $exception;
            $response = ApiResponse::errorSystem($body);
        } else {
            $error = $this->debug ? nl2br((string)$exception) : 'Server internal error';
            $response = new Response(500, [], $error);
        }
        return $response;
    }
}
