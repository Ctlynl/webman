<?php declare(strict_types=1);
return [
    'enable' => filter_var(getenv('NACOS_ENABLE'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
    'host' => getenv('NACOS_HOST'),
    'port' => getenv('NACOS_PORT'),
    'username' => getenv('NACOS_USER') ?: null,
    'password' => getenv('NACOS_PASS') ?: null,
    // 阿里云微服务引擎MSE
    'access_key_id' => getenv('NACOS_ACCESS_KEY_ID') ?: null,
    'access_key_secret' => getenv('NACOS_ACCESS_KEY_SECRET') ?: null,

    /** 长轮询等待时长 毫秒 @desc 当长轮询间隔不存在时，该项作为默认值使用，其余时间则不生效 */
    'long_pulling_timeout' => 30000,

    /** 长轮询间隔 秒 @desc 组件包主要使用该项作为监听器间隔，使用{该值 * 1000}作为长轮询等待时长 */
    'long_pulling_interval' => 30,

    /** float 实例心跳间隔 秒 */
    'instance_heartbeat' => 5.0,

    /** int 进程重试间隔 秒 */
    'process_retry_interval' => 5,

    /** 日志 channel，为 null 时使用默认通道 */
    'log_channel' => null,

    /**配置文件监听器*/
    'config_listeners' => [
        [
            /** DataID */
            'redis.php',
            /** groupName */
            'DEFAULT_GROUP',
            /** namespaceId */
            '',
            /** filePath @desc 配置文件本地保存的地址 */
            config_path('redis.php')
        ],
        [
            /** DataID */
            'database.php',
            /** groupName */
            'DEFAULT_GROUP',
            /** namespaceId */
            '',
            /** filePath @desc 配置文件本地保存的地址 */
            config_path('database.php')
        ]
    ],
];
