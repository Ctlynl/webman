<?php

use Webman\Route;

Route::disableDefaultRoute();

$path = base_path('routes');
foreach (scandir($path) as $item) {
    if ($item != '.' && $item != '..') {
        $fullPath = $path . DIRECTORY_SEPARATOR . $item;
        if (is_file($fullPath)) {
            require_once $fullPath;
        }
    }
}
