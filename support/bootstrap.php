<?php

use Dotenv\Dotenv;
use support\Log;
use Webman\Bootstrap;
use Webman\Config;
use Webman\Middleware;
use Webman\Route;
use Webman\Util;

$worker = $worker ?? null;

set_error_handler(function ($level, $message, $file = '', $line = 0) {
    if (error_reporting() & $level) {
        throw new ErrorException($message, 0, $level, $file, $line);
    }
});

if ($worker) {
    register_shutdown_function(function ($startTime) {
        if (time() - $startTime <= 0.1) {
            sleep(1);
        }
    }, time());
}

if (class_exists('Dotenv\Dotenv') && file_exists(base_path(false) . '/.env')) {
    if (method_exists('Dotenv\Dotenv', 'createUnsafeMutable')) {
        Dotenv::createUnsafeMutable(base_path(false))->load();
    } else {
        Dotenv::createMutable(base_path(false))->load();
    }
}

Config::clear();
support\App::loadAllConfig(['route']);
if ($timezone = config('app.default_timezone')) {
    date_default_timezone_set($timezone);
}

foreach (config('autoload.files', []) as $file) {
    include_once $file;
}
foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (!is_array($project)) {
            continue;
        }
        foreach ($project['autoload']['files'] ?? [] as $file) {
            include_once $file;
        }
    }
    foreach ($projects['autoload']['files'] ?? [] as $file) {
        include_once $file;
    }
}

Middleware::load(config('middleware', []));
foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (!is_array($project) || $name === 'static') {
            continue;
        }
        Middleware::load($project['middleware'] ?? []);
    }
    Middleware::load($projects['middleware'] ?? [], $firm);
    if ($staticMiddlewares = config("plugin.$firm.static.middleware")) {
        Middleware::load(['__static__' => $staticMiddlewares], $firm);
    }
}
Middleware::load(['__static__' => config('static.middleware', [])]);

foreach (config('bootstrap', []) as $className) {
    if (!class_exists($className)) {
        $log = "Warning: Class $className setting in config/bootstrap.php not found\r\n";
        echo $log;
        Log::error($log);
        continue;
    }
    /** @var Bootstrap $className */
    $className::start($worker);
}

foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (!is_array($project)) {
            continue;
        }
        foreach ($project['bootstrap'] ?? [] as $className) {
            if (!class_exists($className)) {
                $log = "Warning: Class $className setting in config/plugin/$firm/$name/bootstrap.php not found\r\n";
                echo $log;
                Log::error($log);
                continue;
            }
            /** @var Bootstrap $className */
            $className::start($worker);
        }
    }
    foreach ($projects['bootstrap'] ?? [] as $className) {
        /** @var string $className */
        if (!class_exists($className)) {
            $log = "Warning: Class $className setting in plugin/$firm/config/bootstrap.php not found\r\n";
            echo $log;
            Log::error($log);
            continue;
        }
        /** @var Bootstrap $className */
        $className::start($worker);
    }
}

$directory = base_path() . '/plugin';
$paths = [config_path()];
foreach (Util::scanDir($directory) as $path) {
    if (is_dir($path = "$path/config")) {
        $paths[] = $path;
    }
}
Route::load($paths);

