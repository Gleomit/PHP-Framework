<?php
namespace DF\Controllers;

use DF\Helpers\Session;

abstract class BaseController
{
    public function __construct()
    {

    }

    protected function isLogged()
    {
        return Session::get('userId') != null;
    }

    protected function getCurrentUserId()
    {
        return Session::get('userId');
    }
}