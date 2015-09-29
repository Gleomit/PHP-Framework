<?php

namespace DF\Routing;


class AbstractRouter
{
    /**
     * @var Route[]
     */
    protected static $routes = [];
    protected static $areas = [];

    /**
     * @param Route $route
     * @return \DF\Routing\RouterAbstract static bound
     */
    public static function addRoute(Route $route) {
        self::$routes[] = $route;

        return new static;
    }
    /**
     * @return Route[]
     */
    public static function getRoutes() {
        return self::$routes;
    }
}