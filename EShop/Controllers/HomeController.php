<?php

namespace DF\Controllers;

use DF\Core\View;

class HomeController extends BaseController
{
    /**
     * @Route("test")
     */
    public function index() {
        return new View("home", ['<script> alert("test"); </script>']);
    }
}