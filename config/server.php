<?php

return [
    'listen' => getenv('SERVER_HOST') . ':' . getenv('SERVER_PORT'),
    'transport' => getenv('SERVER_TRANSPORT'),
    'context' => [],
    'name' => getenv('SERVER_NAME'),
    'count' => getenv('SERVER_COUNT'),
    'user' => getenv('SERVER_USER') ?: '',
    'group' => getenv('SERVER_GROUP') ?: '',
    'reusePort' => false,
    'event_loop' => '',
    'stop_timeout' => getenv('SERVER_STOP_TIMEOUT'),
    'pid_file' => runtime_path() . '/webman.pid',
    'status_file' => runtime_path() . '/webman.status',
    'stdout_file' => runtime_path() . '/logs/stdout.log',
    'log_file' => runtime_path() . '/logs/workerman.log',
    'max_package_size' => 10 * 1024 * 1024
];
