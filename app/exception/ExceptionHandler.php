<?php

namespace app\exception;

use app\support\ApiResponse;
use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;

class ExceptionHandler extends \Webman\Exception\ExceptionHandler
{
    public $dontReport = [
        AppException::class
    ];

    public function render(Request $request, Throwable $exception): Response
    {
        if ($exception instanceof AppException) {
            return ApiResponse::errorByAppException($exception);
        }
        if ($request->expectsJson()) {
            $body = [];
            $this->debug && $body['traces'] = $exception->getMessage() . $exception;
            return ApiResponse::errorSystem($body);
        }
        $error = $this->debug ? nl2br((string)$exception) : 'Server internal error';
        return new Response(500, [], $error);
    }
}
