<?php
session_start();

require 'application/libs/deb.php';
require 'application/libs/Utils.php';
use application\main\Router;
use application\libs\Utils;

function nameSpaceAutoload($class){
    $path = str_replace('\\', '/',$class.'.php');
    if (file_exists($path)){
        require $path;
    }
}

spl_autoload_register('nameSpaceAutoload');
$router = new Router();
$router->run();

spl_autoload_unregister('nameSpaceAutoload');
?>