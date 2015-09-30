<?php

namespace DF\Helpers;


class Csrf
{
    public static function setCSRFToken(){
        Session::put('csrf_token', uniqid(mt_rand(), true));
        return Session::get('csrf_token');
    }
    public static function getCSRFToken() {
        return Session::get('csrf_token');
    }
}