<?php

namespace app\constant;

class StatusCode
{
    const SUCCESS = 0;

    const SYSTEM_ERROR = 500;

    protected static array $message = [
        self::SUCCESS => 'success',
        self::SYSTEM_ERROR => 'system_error'
    ];

    public static function getMessage(int $status): string
    {
        return self::$message[$status] ?? '未知异常';
    }
}
