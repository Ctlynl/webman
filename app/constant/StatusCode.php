<?php

namespace app\constant;

class StatusCode
{
    const SUCCESS = 0;

    const SYSTEM_ERROR = 500;

    const REQUEST_PARAM_ERROR = 422;

    protected static array $message = [
        self::SUCCESS => 'success',
        self::SYSTEM_ERROR => 'system_error',
        self::REQUEST_PARAM_ERROR => 'parameter_error',
    ];

    public static function getMessage(int $status): string
    {
        return self::$message[$status] ?? '未知异常';
    }
}
