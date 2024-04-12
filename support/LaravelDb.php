<?php

namespace support;

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\MySqlConnection;
use Webman\Bootstrap;
use Workerman\Timer;
use Workerman\Worker;
use function class_exists;
use function config;

class LaravelDb implements Bootstrap
{
    /**
     * @param Worker|null $worker
     *
     * @return void
     */
    public static function start(?Worker $worker)
    {
        if (!class_exists(Capsule::class)) {
            return;
        }
        $config = config('database', []);
        $connections = $config['connections'] ?? [];
        if (!$connections) {
            return;
        }
        $capsule = new Capsule(IlluminateContainer::getInstance());
        $default = $config['default'] ?? false;
        if ($default) {
            $defaultConfig = $connections[$config['default']];
            $capsule->addConnection($defaultConfig);
        }
        foreach ($connections as $name => $config) {
            $capsule->addConnection($config, $name);
        }
        $capsule->setAsGlobal();
        // Heartbeat
        if ($worker) {
            Timer::add(55, function () use ($capsule) {
                foreach ($capsule->getDatabaseManager()->getConnections() as $connection) {
                    /* @var MySqlConnection $connection * */
                    if ($connection->getConfig('driver') == 'mysql') {
                        $connection->select('select 1');
                    }
                }
            });
        }
    }
}
