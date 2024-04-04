<?php

namespace app\support;

use app\constant\StatusCode;
use app\exception\AppException;
use support\Response;

class ApiResponse
{
    private int $code;

    private array $data;

    public function __construct(int $code, array $data = [])
    {
        $this->code = $code;
        $this->data = $data;
    }

    public function response($otherBody = []): Response
    {
        $message = StatusCode::getMessage($this->code);
        $response = ['code' => $this->code, 'message' => $message];
        !empty($this->data) && $response['data'] = $this->data;
        $response = array_merge($response, $otherBody);
        $jsonData = json_encode($response, JSON_UNESCAPED_UNICODE);
        return new Response(200, ['Content-Type' => 'application/json'], $jsonData);
    }

    public static function success(array $data): Response
    {
        return (new ApiResponse(StatusCode::SUCCESS, $data))->response();
    }

    public static function errorByAppException(AppException $appException): Response
    {
        return (new ApiResponse($appException->getCode()))->response();
    }

    public static function errorSystem(array $otherBody = []): Response
    {
        return (new ApiResponse(StatusCode::SYSTEM_ERROR))->response($otherBody);
    }
}
