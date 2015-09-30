<?php

namespace DF;

use DF\Core\View;
use DF\Routing\Router;

class FrontController {
    private $controller;
    private $action;

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
            $this->router->parseUrl();
            $this->initRequest();
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
        $this->request = Request::handle();
    }
}