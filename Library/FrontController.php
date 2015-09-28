<?php

namespace DF\Library;

use DF\App;

class FrontController {
    private $controller;
    private $action;

    /**
     * @var View
     */
    private $view;
    private $app;

    private $router;
    private $request;

    public function __construct(App $app, View $view) {
        $this->app = $app;
        $this->view = $view;
    }

    public function dispatch() {
        try {
            $this->initRequest();
            $this->initController();
            $this->initAction();
            $this->controller->render();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function setRouter($router) {
        $this->router = $router;
    }

    public function getRouter() {
        return $this->router;
    }

    public function getController() {
        return $this->controller;
    }

    private function initController() {
        if (!empty($this->getRouter()->getController())) {
            $class = 'ANSR\Controllers\\' . $this->getRouter()->getController();
            if (!class_exists($class)) {
                throw new \ANSR\Library\Exception\LoadException('Controller not found');
            }
            $this->_controller = new $class($this->_app, $this->_view, $this->_request);
        }
    }
    private function initAction() {
        if (!empty($this->getRouter()->getAction())) {
            $this->_method = $this->getRouter()->getAction();
            $this->callMethod();
        }
    }
    private function callMethod() {
        if (!method_exists($this->getController(), $this->action)) {
            throw new \Exception("Undefined method.");
        }
        $action = $this->action;
        if (\ANSR\Library\Registry\Registry::get('WEB_SERVICE') === true) {
            die(json_encode($this->mapMethodArguments($action)));
        } else {
            $this->mapMethodArguments($action);
        }
    }
}