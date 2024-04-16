# web-server-api

````
缺少的配置文件
redis.php database.php server.php

可以通过这个地址找到初始化配置文件信息
https://github.com/walkor/webman/tree/master/config
````

### 安装
````
所有项目配置文件地址
https://github.com/walkor/webman/tree/master/config

composer install -vvv
cp .env.example .env

````

### 通过nacos获取配置文件

````
配置 .env nacos信息
执行 php start.php start 会预拉取配置文件到config文件夹
执行 stop restart reload status connections 不会执行
提醒：server.php 是预拉取 进程启动不会动态重新加载配置
````

### 不使用nacos获取配置文件

````
打开项目配置文件地址
复制缺少的配置文件到config目录下
进行初始化配置
````
