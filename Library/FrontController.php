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

    public function __construct(App $app, View $view) {
        $this->app = $app;
        $this->view = $view;
    }

    public function dispatch() {
        try {
            $this->initController();
            $this->initAction();
            //$this->controller->render();
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

            $class = 'DF\Controllers\\' . $this->getRouter()->getController();

            if (!class_exists($class)) {
                throw new \Exception('Controller not found');
            }

            $this->controller = new $class($this->app, $this->view, $this->request);
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

    private function initRequest() {

    }
}