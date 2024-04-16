<?php

namespace app\command;

use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webman\Config;

class PullNacosConfig extends Command
{
    protected static $defaultName = 'pull:config';
    protected static $defaultDescription = '拉取nacos配置文件';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //If enabled, pull the initialization configuration file
        $config = config('plugin.workbunny.webman-nacos.app');
        if (!empty($config['enable'])) {
            $client = \Workbunny\WebmanNacos\Client::channel();
            foreach (array_merge($config['my_init_configs'], $config['config_listeners']) as $value) {
                list($dataId, $group, $tenant, $configPath) = $value;
                $configValue = $client->config->get($dataId, $group, $tenant);
                if ($configValue === false) {
                    $output->writeln("<error>{$client->config->getMessage()}</error>");
                    return self::FAILURE;
                }
                file_put_contents($configPath, $configValue);
                $output->writeln("{$configPath}写入成功");
            }
        } else {
            // 如果nacos配置没有开启,则自己引入config配置文件
            Config::load(config_path('plugin/workbunny/webman-nacos'), [], 'my.nacos.config');
            $config = \config('my.nacos.config.app');
            // Check if these configuration files exist locally
            foreach (array_merge($config['my_init_configs'], $config['config_listeners']) as $config) {
                if (!file_exists($config[3])) {
                    $output->writeln("<error>please add $config[3] file</error>");
                    return self::FAILURE;
                }
            }
        }
        $output->writeln("success");
        return self::SUCCESS;
    }
}
