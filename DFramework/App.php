<?php

namespace DF;

use DF\Helpers\Csrf;
use DF\Helpers\RouteScanner;
use DF\Helpers\Session;
use DF\Routing\Router;
use DF\Services\RouteService;

class App {

    private static $instance = null;
    public static $WEB_SERVICE = false;

    /**
     * @var FrontController
     */
    private $frontController;

    public function run () {
        error_reporting(E_ALL);

        Session::start();

        $this->initRouteService();

        $this->registerDatabaseConfiguration();

        if(Csrf::getCSRFToken() == null) {
            Csrf::setCSRFToken();
        }
//        RouteScanner::performScan();

        $this->frontController = new FrontController(new Router());
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

    private function initRouteService() {
        $phpSelf = $_SERVER['PHP_SELF'];
        $index = basename($phpSelf);

        RouteService::init(str_replace($index, '', $phpSelf));
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