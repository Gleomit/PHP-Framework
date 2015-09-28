<?php

namespace DF;

class App {

    private static $instance = null;
    private static $WEB_SERVICE = false;

    public function run () {

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

    private function loadRoutes() {

    }
}