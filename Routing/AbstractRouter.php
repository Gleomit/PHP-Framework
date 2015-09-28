<?php

namespace DF\Routing;


class AbstractRouter
{
    /**
     * @var Route[]
     */
    protected static $_routes = [];
    /**
     * @param Route $route
     * @return \DF\Routing\RouterAbstract static bound
     */
    public static function addRoute(Route $route) {
        self::$_routes[] = $route;

        return new static;
    }
    /**
     * @return Route[]
     */
    public static function getRoutes() {
        return self::$_routes;
    }
}