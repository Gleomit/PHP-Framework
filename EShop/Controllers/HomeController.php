<?php

namespace DF\Controllers;

use DF\Core\View;
use DF\Services\RouteService;

class HomeController extends BaseController
{
    /**
     * @return View)
     */
    public function index() {
        return new View("home", []);
    }

    /**
     * @return View
     */
    public function login() {
        if($this->isLogged()) {
            RouteService::redirect('account', 'profile', true);
        }

        return new View("user\\login", []);
    }

    public function register() {
        if($this->isLogged()) {
            RouteService::redirect('account', 'profile', true);
        }

        return new View("user\\register", []);
    }

    /**
     * @return View
     * @Route("404")
     */
    public function notFound() {
        return new View("404", []);
    }
}