<?php
namespace DF\Services;

class RouteService
{
    public static $basePath;

    public static function init($basePath)
    {
        self::$basePath = $basePath;
    }

    public static function redirect($controller, $action, $requestParams = [], $exit = false)
    {
        $location = self::$basePath
            . "$controller/"
            . $action
            . implode("/", $requestParams);

        header("Location: " . $location);

        if($exit) {
            exit;
        }
    }

    public static function getUrl($controller, $action, $requestParams = [])
    {
        $location = self::$basePath
            . "$controller/"
            . "$action/";

        if(count($requestParams) > 0) {
            $location .= implode("/", $requestParams);
        }

        return $location;
    }
}