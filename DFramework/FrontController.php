<?php

namespace DF;

use DF\Config\AppConfig;
use DF\Core\Request;
use DF\Core\View;
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
    private $request;

    public function __construct(App $app, View $view) {
        $this->app = $app;
        $this->view = $view;
        $this->view->setFrontController($this);
    }

    public function dispatch() {
        try {
            $this->getRouter()->parseUrl();
            //$this->initRequest();
            $this->initController();
            $this->initAction();
            //$this->controller->render();
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
            $this->controller = new $class($this->app, $this->view, $this->request);
            $this->isRequestMethodValid();
        }
    }
    private function initAction() {
        if (!empty($this->getRouter()->getAction())) {
            $this->action = $this->getRouter()->getAction();
            $this->invokeAction();
        }
    }
    private function invokeAction() {
        if (!method_exists($this->getController(), $this->action)) {
            throw new \Exception("Undefined method.");
        }

        $action = $this->action;

        $this->getController()->$action();
    }

    private function isRequestMethodValid(){
        $refClass = new \ReflectionClass($this->controllerString);
        $refMethod = $refClass->getMethod($this->getRouter()->getAction());

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

        //binding models and parameter mapping - needs to be implemented

        $refMethodParams = $refMethod->getParameters();

        if(count($refMethodParams) != count($this->getRouter()->routeInfo['parameters']))

        var_dump($refMethod->getParameters());
    }

    private function isRequestMethodSignatureValid() {

    }

    private function initRequest() {
        $this->request = Request::handle();
    }
}