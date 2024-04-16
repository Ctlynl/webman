<?php

use app\exception\ProjectBootException;
use Webman\Config;

if (empty($argv[1]) || $argv[1] != 'start') {
    return false;
}
if (file_exists(run_path('.env'))) {
    Dotenv\Dotenv::createUnsafeMutable(base_path(false))->load();
}
// load config nacos file
Config::load(config_path('/plugin/workbunny/webman-nacos'), [], 'plugin.workbunny.webman-nacos');
$nacosAppConfig = config('plugin.workbunny.webman-nacos.app');
//If enabled, pull the initialization configuration file
if ($nacosAppConfig['enable']) {
    $client = Workbunny\WebmanNacos\Client::channel();
    foreach (array_merge($nacosAppConfig['my_init_configs'], $nacosAppConfig['config_listeners']) as $config) {
        list($dataId, $group, $tenant, $configPath) = $config;
        $configValue = $client->config->get($dataId, $group, $tenant);
        if ($configValue === false) {
            throw new ProjectBootException("get nacos config error,{$client->config->getMessage()}");
        }
        file_put_contents($configPath, $configValue, LOCK_EX);
    }
} else {
    // Check if these configuration files exist locally
    foreach (array_merge($nacosAppConfig['my_init_configs'], $nacosAppConfig['config_listeners']) as $config) {
        if (!file_exists($config[3])) {
            throw new ProjectBootException("please add $config[3] file");
        }
    }
}
// clear config all params
unset($nacosAppConfig, $client, $dataId, $group, $tenant, $configPath, $configValue, $config);
Config::clear();
