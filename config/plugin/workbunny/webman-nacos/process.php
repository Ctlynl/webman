<?php
declare(strict_types=1);

return [
    'config-listener' => [
        # 多Timber异步监听器，多个监听异步非阻塞执行
        'handler' => \Workbunny\WebmanNacos\Process\AsyncConfigListenerProcess::class
    ]
];
