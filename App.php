<?php

namespace DF;

use DF\Library\FrontController;
use DF\Library\View;
use DF\Routing\Router;

class App {

    private static $instance = null;
    public static $WEB_SERVICE = false;

    public function run () {
        $frontController = new FrontController($this, new View());
        $frontController->setRouter(new Router());
        $frontController->dispatch();
    }

    /**
     * @return \DF\App|null
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new \DF\App();
        }

        return self::$instance;
    }
}