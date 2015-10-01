<?php

namespace DF\Areas\Test\Controllers;

/**
 * Class TestController
 * @package DF\Areas\Test\Controllers
 * @Authorize
 */
class TestController
{
    /**
     * @Route("")
     */
    public function index() {
        echo 'from area';
    }
}