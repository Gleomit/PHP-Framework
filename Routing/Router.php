<?php

namespace DF\Routing;

use DF\Config\AppConfig;

class Router extends AbstractRouter
{
    /**
     * @var array
     */

    const REQUEST_URI_CONTROLLER = 2;
    const REQUEST_URI_ACTION = 3;

    private $controller = "HomeController";
    private $action = "index";

    public function __construct() {

    }

    public function checkRoute($urlParts) {
        $result = true;

        if(!class_exists('DF\\Controllers\\' . $urlParts[0])) {
            $result = false;

            return $result;
        }

        $class = 'DF\\Controllers\\' . $urlParts[0];
        $class = new $class;

        if(method_exists($class, $urlParts[1])) {
            return $result;
        }

        foreach(self::$routes as $route) {
            if($route->getController() == $urlParts[0] && $route->getAction() == $urlParts[1]) {
                break;
            }
        }

        return $result;
    }

    private function checkArea($url) {
        foreach(self::$areas as $area) {

        }
    }

    public function parseUrl() {
        if(isset($_GET['url'])) {
            $urlParts = explode('/', $_GET['url']);

            $partsCount = count($urlParts);

            if($partsCount > 2) {

            } elseif($partsCount == 2) {

            }
        }
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }
}