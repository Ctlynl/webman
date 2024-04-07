<?php

use Webman\Route;

// 定义通用路由
Route::get('/index', [app\controller\IndexController::class, 'index']);
