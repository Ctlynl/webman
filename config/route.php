<?php

use Webman\Route;

Route::disableDefaultRoute();

$path = base_path('routes');
foreach (scandir(base_path('routes')) as $item) {
    if ($item != '.' && $item != '..') {
        $fullPath = $path . DIRECTORY_SEPARATOR . $item;
        $iterator = new RecursiveDirectoryIterator($fullPath, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
        foreach ($files as $file) {
            if ($file->isFile() && $file->getExtension() == 'php') {
                include_once $file->getRealPath();
            }
        }
    }
}
