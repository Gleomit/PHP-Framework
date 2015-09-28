<?php

require_once 'Library\Autoloader.php';

DF\Library\Autoloader::register();

$app = new \DF\App();
$app->run();