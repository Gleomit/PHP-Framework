<?php

namespace DF;

use DF\Config\AppConfig;
use DF\Core\Request;
use DF\Core\View;
use DF\Helpers\Csrf;
use DF\Helpers\Session;
use DF\Routing\Router;
use DF\Services\RoleService;

class FrontController {
    private $controller;
    private $action;
    private $controllerString;
    /**
     * @var View
     */
    private $view;
    private $app;

    /**
     * @var /DF/Routing/Router
     */
    private $router;
    /**
     * @var Request
     */
    private $request;

    public function __construct(App $app, View $view) {
        $this->app = $app;
        $this->view = $view;
        $this->view->setFrontController($this);
    }

    public function dispatch() {
        try {
            $this->initRequest();
            $this->getRouter()->parseUrl();
            $this->initController();
            $this->invokeTheRoute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function setRouter(Router $router) {
        $this->router = $router;
    }

    /**
     * @return \DF\Routing\Router
     */
    public function getRouter() {
        return $this->router;
    }

    public function getController() {
        return $this->controller;
    }

    private function initController() {
        if (!empty($this->getRouter()->getController())) {
            $classString = 'DF';


            if(!empty($this->getRouter()->routeInfo['areaName'])) {
                $classString .= '\\Areas\\' . $this->getRouter()->routeInfo['areaName'];
            }

            $class = $classString . '\\Controllers\\' . $this->getRouter()->getController() . AppConfig::CONTROLLER_SUFFIX;

            if (!class_exists($class)) {
                throw new \Exception('Controller not found');
            }

            $this->controllerString = $class;
            $this->controller = new $class();
        }
    }

    private function invokeTheRoute(){
        if($_SERVER['REQUEST_METHOD'] != $this->getRouter()->routeInfo['requestType']) {
            throw new \Exception("Wrong request method.");
        }

        if(!Session::exists('userId') && $this->getRouter()->routeInfo['authorize'] == true) {
            throw new \Exception("Unauthorized");
        }

        if(count($this->getRouter()->routeInfo['roles']) > 0) {
            if(!RoleService::userInRole(Session::get('userId'), $this->getRouter()->routeInfo['roles'])) {
                throw new \Exception("You do not have the rights");
            }
        }

        if(count($this->getRouter()->routeInfo['bindingModels']) > 0) {
            if(count($this->request->getParams()) == 0) {
               throw new \Exception("Action expecting post/put binding model, request has 0");
            }

            $requestParameters = $this->request->getParams();
            $requestParamsKeys = array_keys($requestParameters);

            $csrfToken = false;

            if(in_array('csrf_token', $requestParamsKeys)) {
                $csrfToken = $requestParameters['csrf_token'];

                unset($requestParameters['csrf_token']);
            }

            foreach($this->getRouter()->routeInfo['bindingModels'] as $bindingModelName) {
                $refClass = new \ReflectionClass($bindingModelName);

                $bindingModel = new $bindingModelName();

                foreach($refClass->getProperties() as $property) {
                    $propertyName = $property->getName();

                    if(!in_array($propertyName, $requestParamsKeys)) {
                        throw new \Exception("Binding model does not have property with name: $propertyName");
                    }

                    $bindingModel->$propertyName = $requestParameters[$propertyName];

                    unset($requestParameters[$propertyName]);
                    unset($requestParamsKeys[array_search($propertyName, $requestParamsKeys)]);
                }

                $this->getRouter()->routeParams[] = $bindingModel;
            }

            if(Request::needToChangeCsrf()) {
                if(Csrf::getCSRFToken() != $csrfToken) {
                    throw new \Exception("Invalid token");
                }
            }
        }

        call_user_func_array(array($this->getController(), $this->getRouter()->getAction()), $this->getRouter()->routeParams);

        if(Request::needToChangeCsrf()) {
            Csrf::setCSRFToken();
        }
    }

    private function initRequest() {
        $this->request = Request::handle();
    }
}