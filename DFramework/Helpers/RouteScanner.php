<?php

namespace DF\Helpers;


use DF\Config\AppConfig;

class RouteScanner
{
    public function getAllControllersRoutes($getOnlyRoutes = false) {
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

        if($getOnlyRoutes === true) {
            $onlyRoutes = [];

            foreach($controllersRoutes as $controllerValue) {
                foreach(array_values($controllerValue) as $route) {
                    $onlyRoutes[] = $route;
                }
            }

            $controllersRoutes = $onlyRoutes;
        }

        return $controllersRoutes;
    }

    public function getAreasControllersRoutes($areasFolder, $getOnlyRoutes = false) {
        $areasRoutes = [];

        $areasFolders = scandir($areasFolder);

        foreach($areasFolders as $areaFolder){
            if(ctype_alnum($areaFolder) && is_dir($areasFolder . '/' . $areaFolder)) {
                $declaredControllers = scandir($areasFolder . '/' . $areaFolder);

                if(!in_array('Controllers', $declaredControllers)) {
                    continue;
                }

                $declaredControllers = scandir($areasFolder . '/' . $areaFolder . '/Controllers');

                $areasRoutes[$areaFolder] = [];

                foreach($declaredControllers as $fileName) {
                    if(strpos($fileName, '.php') != false){
                        $controllerClassName = (substr($fileName, 0, strlen($fileName) - 4));

                        //DF/Areas . AreaName . / Controllers . / ControllerName

                        $controllerFullClassName = 'DF\\Areas\\' . $areaFolder . '\\Controllers\\' . $controllerClassName;

                        $controllerRoutes = [];

                        if($controllerClassName != 'BaseController') {
                            $controller = new $controllerFullClassName();

                            $controllerRoutes = self::getControllerRoutes($controller, strtolower($areaFolder));
                            $areasRoutes[$areaFolder][$controllerClassName] = $controllerRoutes;
                        }
                    }
                }
            }
        }


        if($getOnlyRoutes === true) {
            $onlyRoutes = [];

            foreach(array_values($areasRoutes) as $controllerValue) {

                foreach(array_values($controllerValue) as $route) {
                    $onlyRoutes[] = $route[0];
                }
            }

            $areasRoutes = $onlyRoutes;
        }

        return $areasRoutes;
    }

    private static function getControllerRoutes($controller, $areaName = null) {
        $refClass = new \ReflectionClass($controller);
        $methods = $refClass->getMethods();

        $classDoc = $refClass->getDocComment();

        preg_match_all("/@Route\(\"(.+)\"\)/", $classDoc, $classRoute);
        preg_match_all("/@Authorize/", $classDoc, $classAuthorize);

        $controllerName = str_replace("Controller", "", $refClass->getShortName());
        $baseRoute = strtolower($controllerName) . '/';
        $classAuthorized = count($classAuthorize[0]) > 0;

        if(count($classRoute[0]) > 0) {
            $baseRoute = $classRoute[1][0];
        }

        $resultMethods = [];


        foreach($methods as $method) {
            if($method->getName() != '__construct') {
                $methodDoc = $method->getDocComment();

                preg_match_all("/@Route\(\"(.*)\"\)/", $methodDoc, $methodRoute);
                preg_match_all("/@GET|@PUT|@DELETE|@POST/", $methodDoc, $methodType);
                preg_match_all("/@Authorize/", $methodDoc, $methodAuthorize);
                preg_match_all("/@Roles\(.*\)/", $methodDoc, $methodRoles);
                preg_match_all("/@Anonymous/", $methodDoc, $methodAnonymous);

                $methodKey = $baseRoute . $method->getName();

                $methodArray = [];
                $methodArray['route'] = $methodKey;
                $methodArray['controller'] = $controllerName;
                $methodArray['action'] = $method->getName();
                $methodArray['requestType'] = 'GET';
                $methodArray['authorize'] = $classAuthorized;
                $methodArray['roles'] = [];
                $methodArray['parameters'] = [];
                $methodArray['areaName'] = "";


                if(count($methodRoute[0]) > 0) {
                    $methodKey = $baseRoute . $methodRoute[1][0];
                    $methodArray['route'] = $methodKey;

                    preg_match_all("/\/*(\{(\w+):(\w+)\})\/*/", $methodRoute[1][0], $methodParameters);

                    $params = [];

                    // check if parameters are equal(length and signature)

                    for($i = 0; $i < count($methodParameters[0]); $i++) {
                        $params[$methodParameters[2][$i]] = $methodParameters[3][$i];

                        switch($methodParameters[3]{$i}) {
                            case 'num': {
                                $methodKey = preg_replace("/(\{(\w+):(\w+)\})/", "\d+", $methodKey);
                            }
                            case 'any': {
                                $methodKey = preg_replace("/\/*(\{(\w+):(\w+)\})\/*/", ".*", $methodKey);
                            }
                        }
                    }

                    $methodArray['parameters'] = $params;
                }

                if(count($methodType[0]) > 0) {
                    $methodArray['requestType'] = str_replace("@", "", $methodType[0][0]);
                }

                if(count($methodAuthorize[0]) > 0) {
                    $methodArray['authorize'] = true;
                } else if(count($methodAnonymous[0]) > 0) {
                    $methodArray['authorize'] = false;
                }

                if(count($methodRoles[0]) > 0) {
                    $methodArray['roles'] = explode(',', $methodRoles[0]);
                    $methodArray['authorize'] = true;
                }

                if($areaName != null) {
                    $methodKey = $areaName . '/' . $methodKey;
                    $methodArray['route'] = $methodKey;
                    $methodArray['areaName'] = $areaName;
                }

                $methodKey = preg_replace("/\//", "\/", $methodKey);

                $methodArray['methodPattern'] = $methodKey;

                $resultMethods[] = $methodArray;
            }
        }

        return $resultMethods;
    }
}