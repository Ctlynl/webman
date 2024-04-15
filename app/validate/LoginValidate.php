<?php

namespace app\validate;

use Tinywan\Validate\Validate;

class LoginValidate extends Validate
{
    protected bool $failException = true;

    protected bool $batch = true;

    protected array $rule = [
        'userName' => 'require|string',
        'password' => 'require|string',
        'key' => 'require|string'
    ];

    protected array $message = [
        'userName.require' => '账号必须填写',
        'userName.string' => '账号必须为字符串',
        'password.require' => '密码必须填写',
        'password.string' => '密码必须为字符串',
        'key.require' => 'key不能为空',
        'key.string' => 'key必须为字符串',
    ];
}
