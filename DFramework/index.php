<?php

require_once 'AutoLoader.php';

\DF\AutoLoader::register();

$app = new \DF\App();
$app->run();