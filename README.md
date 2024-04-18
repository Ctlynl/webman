# web-server-api

## 缺失配置文件
缺失以下配置文件：`redis.php` `database.php` `server.php`

可在此处下载初始化配置文件
[Webman Config](https://github.com/walkor/webman/tree/master/config)

## 安装指南

**安装依赖并初始化环境**:
```bash
composer install -vvv

cp .env.example .env
```

### 使用 Nacos 管理配置
```` bash
在 .env 中配置 Nacos 信息

在 nacos 服务端配置信息

启动服务：php start.php start，自动预拉取配置到config
````

### 不使用 Nacos 获取配置文件

````
复制缺少的配置文件到config目录下进行初始化配置
````
