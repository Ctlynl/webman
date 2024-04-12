<?php

namespace support;

class Validate extends \Tinywan\Validate\Facade\Validate
{
    public static function start($worker)
    {
        if ($worker) {
            // 添加自定义验证规则
            \Tinywan\Validate\Validate::maker(function ($validate) {
                $validate->extend('string', function ($value) {
                    return is_string($value);
                }, 'the field is a string');
            });
            static::$_instance = new \Tinywan\Validate\Validate();
        }
    }
}
