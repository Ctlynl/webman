<?php

use Webman\Route;

Route::group('/v1', function () {
    Route::get('/index', [app\controller\IndexController::class, 'index']);
});
