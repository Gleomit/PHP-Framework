<?php

namespace DF;

class App {

    private static $_instance = null;

    public function run () {

    }

    /**
     * @return \DF\App|null
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new \DF\App();
        }

        return self::$_instance;
    }
}