<?php declare(strict_types=1);
return [
    'default' => [
        'host' => getenv('NACOS_HOST') ?: 'localhost',
        'port' => getenv('NACOS_PORT') ?: 8848,
        'username' => getenv('NACOS_USER') ?: null,
        'password' => getenv('NACOS_PASS') ?: null,
        // 阿里云微服务引擎MSE
        'access_key_id' => getenv('NACOS_ACCESS_KEY_ID') ?: null,
        'access_key_secret' => getenv('NACOS_ACCESS_KEY_SECRET') ?: null,
    ],
];
