<?php
namespace DF\Helpers;

use DF\App;
use DF\Config\AppConfig;

class RouteScanner
{
    public function getAllControllersRoutes($getOnlyRoutes = false)
    {
        $controllersRoutes = [];

        $declaredControllerFiles = scandir('Controllers');

        $controllersNamespace = AppConfig::FRAMEWORK_CONTROLLERS_NAMESPACE;

        foreach($declaredControllerFiles as $fileName){
            if(strpos($fileName, '.php') != false){
                $controllerClassName = (substr($fileName, 0, strlen($fileName) - 4));
                $controllerFullClassName = $controllersNamespace . '\\' . $controllerClassName;

                if($controllerClassName != 'BaseController') {
                    $controller = new $controllerFullClassName();

                    $controllersRoutes[$controllerClassName] = $this->getControllerRoutes($controller);
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

    public function getAreasControllersRoutes($areasFolder, $getOnlyRoutes = false)
    {
        $areasRoutes = [];

        $areasFolders = scandir($areasFolder);

        $areasNamespace = AppConfig::FRAMEWORK_NAMESPACE . '\\Areas';


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

                        $controllerFullClassName = $areasNamespace . '\\' . $areaFolder . '\\Controllers\\' . $controllerClassName;

                        $controllerRoutes = [];

                        if($controllerClassName != 'BaseController') {
                            $controller = new $controllerFullClassName();

                            $controllerRoutes = $this->getControllerRoutes($controller, strtolower($areaFolder));
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

    private function getControllerRoutes($controller, $areaName = null)
    {
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
                preg_match_all("/@Roles\((.+)\)/", $methodDoc, $methodRoles);
                preg_match_all("/@Anonymous/", $methodDoc, $methodAnonymous);

                $methodKey = $baseRoute;

                if($method->getName() != 'index') {
                    $methodKey .= $method->getName();
                }

                $methodArray = [];
                $methodArray['route'] = $methodKey;
                $methodArray['controller'] = $controllerName;
                $methodArray['action'] = $method->getName();
                $methodArray['requestType'] = 'GET';
                $methodArray['authorize'] = $classAuthorized;
                $methodArray['roles'] = [];
                $methodArray['parameters'] = [];
                $methodArray['areaName'] = "";
                $methodArray['bindingModels'] = [];

                if(count($methodRoute[0]) > 0) {
                    $methodKey = $baseRoute . $methodRoute[1][0];
                    $methodArray['route'] = $methodKey;
                }

                preg_match_all("/\/*(\{(\w+):(\w+)\})\/*/", $methodArray['route'], $methodParameters);

                $params = [];

                for($i = 0; $i < count($methodParameters[0]); $i++) {
                    $params[$methodParameters[2][$i]] = $methodParameters[3][$i];

                    switch($methodParameters[3]{$i}) {
                        case 'num': {
                            $methodKey = preg_replace("/(\{(\w+):(\w+)\})/", "(\d+)", $methodKey);
                            break;
                        }
                        case 'any': {
                            $methodKey = preg_replace("/\/*(\{(\w+):(\w+)\})\/*/", ".*", $methodKey);
                            break;
                        }
                    }
                }

                $methodArray['parameters'] = $params;

                $result = $this->checkMethodSignature(array_keys($methodArray['parameters']), $method);

                if($result != null) {
                    $methodArray['bindingModels'] = $result;
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
                    $methodArray['roles'] = preg_split('/\s*,\s*/', $methodRoles[1][0]);

                    if($methodArray['roles'][0] === "") {
                        array_shift($methodArray['roles']);
                    }

                    foreach($methodArray['roles'] as $role) {
                        if(!isset(App::$roles[$role])) {
                            throw new \Exception("Unknown role: $role");
                        }
                    }

                    $methodArray['authorize'] = true;
                }

                if($areaName != null) {
                    $methodKey = $areaName . '/' . $methodKey;
                    $methodArray['route'] = $methodKey;
                    $methodArray['areaName'] = $areaName;
                }

                if($methodKey[strlen($methodKey) - 1] === '/' && substr_count($methodKey, '/') > 1) {
                    $methodKey = substr($methodKey, 0, strlen($methodKey) - 1);
                }

                $methodKey = preg_replace("/\//", "\/", $methodKey);

                $methodArray['methodPattern'] = $methodKey;

                $resultMethods[] = $methodArray;
            }
        }

        return $resultMethods;
    }

    private function checkMethodSignature($routeParams, \ReflectionMethod $method)
    {
        $methodParams = $method->getParameters();

        $bindingModels = $this->checkForBindingModels($methodParams);

        if($bindingModels != false) {
            for($i = 0; $i < count($bindingModels); $i++) {
                array_pop($methodParams);
            }
        }

        if(count($methodParams) != count($routeParams)) {
            throw new \Exception("Mismatch between parameters count in method signature and route signature");
        }

        foreach($methodParams as $param) {
            if(!in_array($param->getName(), $routeParams)) {
                throw new \Exception("Mismatch between parameter names in method signature and route signature");
            }
        }

        return $bindingModels;
    }

    private function checkForBindingModels(array $parameters)
    {
        $bindingModels = [];

        foreach($parameters as $param) {
            if($param->getClass() != NULL && strpos($param->getClass()->getName(), "BindingModels") != false) {
                $bindingModels[] = $param->getClass()->getName();
            }
        }

        if(count($bindingModels) > 0) {
            return $bindingModels;
        }

        return false;
    }
}