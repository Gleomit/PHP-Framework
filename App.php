<?php

namespace DF;

class App {

    private static $instance = null;

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
}