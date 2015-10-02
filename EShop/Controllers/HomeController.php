<?php

namespace DF\Controllers;

use DF\Core\View;
use DF\Services\RouteService;

class HomeController extends BaseController
{
    public function index() {
        echo 'Blqblq';
        return new View("home", []);
    }

    /**
     * @return View
     * @Route("")
     * @POST
     */
    public function login() {
        if($this->isLogged()) {
            RouteService::redirect('account', 'profile', true);
        }

        return new View("user\\login",[]);
    }

    public function register() {
        if($this->isLogged()) {
            RouteService::redirect('account', 'profile', true);
        }

        return new View("user\\register",[]);
    }
}