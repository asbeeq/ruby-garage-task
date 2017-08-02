<?php

require_once 'config.php';
require_once '../vendor/autoload.php';

//spl_autoload_register(function ($class) {
//    $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $class) .'.php';
//    $file = BASE_PATH . DIRECTORY_SEPARATOR . $fileName;
//    if (file_exists($file)) {
//        include $file;
//    }
//});