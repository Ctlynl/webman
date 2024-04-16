<?php

global $argv;

$myMonitorConfigArr = [
    // File update detection and automatic reload
    'monitor' => [
        'handler' => process\Monitor::class,
        'reloadable' => false,
        'constructor' => [
            // Monitor these directories
            'monitorDir' => array_merge([
                app_path(),
                config_path(),
                base_path() . '/process',
                base_path() . '/support',
                base_path() . '/resource',
                base_path() . '/.env',
                base_path() . '/routes',
            ], glob(
                base_path() . '/plugin/*/app'),
                glob(base_path() . '/plugin/*/config'),
                glob(base_path() . '/plugin/*/api')
            ),
            // Files with these suffixes will be monitored
            'monitorExtensions' => [
                'php', 'html', 'htm', 'env'
            ],
            'options' => [
                'enable_file_monitor' => !in_array('-d', $argv) && DIRECTORY_SEPARATOR === '/',
                'enable_memory_monitor' => DIRECTORY_SEPARATOR === '/',
            ]
        ]
    ]
];

// 如果是-d就是后台运行则不运行该进程
if (in_array('-d', $argv) && DIRECTORY_SEPARATOR === '/') {
    unset($myMonitorConfigArr['monitor']);
}
return $myMonitorConfigArr;
