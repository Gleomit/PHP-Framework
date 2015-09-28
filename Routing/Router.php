<?php

namespace DF\Routing;

use DF\Config\AppConfig;

class Router extends AbstractRouter
{
    /**
     * @var array
     */
    private static $areas = [];

    const REQUEST_URI_CONTROLLER = 2;
    const REQUEST_URI_ACTION = 3;

    public function __construct() {

    }

    public function checkRoute() {

    }

    public function getController() {
        return ucfirst(explode('/', $_SERVER['REQUEST_URI'])[self::REQUEST_URI_CONTROLLER]) . AppConfig::CONTROLLER_SUFFIX;
    }

    public function getAction() {
        return explode('/', $_SERVER['REQUEST_URI'])[self::REQUEST_URI_ACTION];
    }
}