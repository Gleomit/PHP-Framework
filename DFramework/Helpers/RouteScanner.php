<?php

namespace DF\Helpers;


use DF\Config\AppConfig;

class RouteScanner
{
    public static function performScan() {
        var_dump(self::getAllControllersRoutes());
    }

    public static function getAllControllersRoutes() {
        $controllersRoutes = [];

        $declaredControllerFiles = scandir('Controllers');

        foreach($declaredControllerFiles as $fileName){
            if(strpos($fileName, '.php') != false){
                $controllerClassName = (substr($fileName, 0, strlen($fileName) - 4));
                $controllerFullClassName = AppConfig::CONTROLLERS_NAMESPACE . $controllerClassName;

                if($controllerClassName != 'BaseController') {
                    $controller = new $controllerFullClassName();

                    $controllersRoutes[$controllerClassName] = self::getControllerRoutes($controller);
                }
            }
        }

        return $controllersRoutes;
    }

    private static function getControllerRoutes($controller) {
        $refClass = new \ReflectionClass($controller);
        $methods = $refClass->getMethods();

        $classDoc = $refClass->getDocComment();

        preg_match_all("/@Route\(\"(.+)\"\)/", $classDoc, $classRoute);
        preg_match_all("/@Authorize/", $classDoc, $classAuthorize);

        $controllerName = str_replace("Controller", "", $refClass->getShortName());
        $baseRoute = strtolower($controllerName) . '/';
        $classAuthorized = count($classAuthorize) > 0;

        if(count($classRoute[0]) > 0) {
            $baseRoute = $classRoute[0];
        }

        $resultMethods = [];


        foreach($methods as $method) {
            if($method->getName() != '__construct') {
                $methodDoc = $method->getDocComment();

                preg_match_all("/@Route\(\"(.+)\"\)/", $methodDoc, $methodRoute);
                preg_match_all("/@GET|@PUT|@DELETE|@POST/", $methodDoc, $methodType);
                preg_match_all("/@Authorize/", $methodDoc, $methodAuthorize);
                preg_match_all("/@Roles\(.*\)/", $methodDoc, $methodRoles);
                preg_match_all("/@Anonymous\(.*\)/", $methodDoc, $methodAnonymouse);

                $methodKey = $baseRoute . $method->getName();

                $methodArray = [];
                $methodArray['route'] = $methodKey;
                $methodArray['controller'] = $controllerName;
                $methodArray['action'] = $method->getName();
                $methodArray['requestType'] = 'GET';
                $methodArray['authorize'] = $classAuthorized;
                $methodArray['roles'] = [];


                if(count($methodRoute[0]) > 0) {
                    $methodKey = $baseRoute . $methodRoute[1][0];
                    $methodArray['route'] = $methodKey;
                }

                if(count($methodType[0]) > 0) {
                    $methodArray['requestType'] = $methodType[0][0];
                }

                if(count($methodAuthorize[0]) > 0) {
                    $methodArray['authorize'] = true;
                } else if(count($methodAnonymouse[0]) > 0) {
                    $methodArray['authorize'] = false;
                }

                if(count($methodRoles[0]) > 0) {
                    $methodArray['roles'] = explode(',', $methodRoles[0]);
                    $methodArray['authorize'] = true;
                }

                $resultMethods[$methodKey] = $methodArray;
            }
        }

        return $resultMethods;
    }
}