<?php

namespace DF;

use DF\FrontController;
use DF\Core\View;
use DF\Helpers\Session;
use DF\Routing\Router;

class App {

    private static $instance = null;
    public static $WEB_SERVICE = false;

    /**
     * @var FrontController
     */
    private $frontController;

    public function run () {
        Session::start();

        $this->registerDatabaseConfiguration();

        $this->frontController = new FrontController($this, new View());
        $this->frontController->setRouter(new Router());
        $this->frontController->dispatch();
    }

    private function registerDatabaseConfiguration() {
        \DF\Core\Database::setInstance(
            \DF\Config\DatabaseConfig::DB_INSTANCE,
            \DF\Config\DatabaseConfig::DB_DRIVER,
            \DF\Config\DatabaseConfig::DB_USER,
            \DF\Config\DatabaseConfig::DB_PASSWORD,
            \DF\Config\DatabaseConfig::DB_NAME,
            \DF\Config\DatabaseConfig::DB_HOST
        );
    }

    public function getFrontController() {
        return $this->frontController;
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