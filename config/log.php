<?php

return [
    'default' => [
        'handlers' => [
            [
                'class' => Monolog\Handler\RotatingFileHandler::class,
                'constructor' => [
                    runtime_path() . '/logs/webman.log',
                    7, //$maxFiles
                    Monolog\Logger::DEBUG,
                ],
                'formatter' => [
                    'class' => Monolog\Formatter\LineFormatter::class,
                    'constructor' => [null, 'Y-m-d H:i:s', true],
                ],
            ]
        ],
        'processor' => function ($record) {
            // 将request-id添加到extra字段中
            if ($requestId = getProjectRequestId()) {
                $record['extra']['requestId'] = $requestId;
            }
            return $record;
        }
    ]
];
