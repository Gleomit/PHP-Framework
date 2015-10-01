<?php

namespace DF\Areas\Test\Controllers;

use DF\Controllers\BaseController;

class TestController extends BaseController
{
    /**
     * @Route("")
     */
    public function index() {
        echo 'test';
    }
}