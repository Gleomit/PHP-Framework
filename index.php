<?php

spl_autoload_register(function ($class) {
    $classPath = str_replace("\\", "/", $class);

    require_once $classPath . '.php';
});

define('BASE_PATH', dirname(realpath(__FILE__)));


$data = (explode('/', $_SERVER['REQUEST_URI']));

array_shift($data);

var_dump($data);

$controller = $data[1];

$filepath = (BASE_PATH . '/Controllers/' . ucfirst($controller) . 'Controller.php');

if (file_exists($filepath)) {
    var_dump(true);
}