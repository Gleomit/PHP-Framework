<?php

namespace DF\Helpers;

class RouteService
{
    private static $basePath;

    public static function init($basePath) {
        self::$basePath = $basePath;
    }

    public static function redirect($controller, $action, $requestParams = [], $exit = false) {
        $location = self::$basePath
            . "$controller/"
            . $action
            . implode("/", $requestParams);

        header("Location: " . $location);

        if($exit) {
            exit;
        }
    }

    public static function getUrl($controller, $action, $requestParams = []) {
        $location = self::$basePath
            . "$controller/"
            . "$action/"
            . implode("/", $requestParams);

        return $location;
    }
}