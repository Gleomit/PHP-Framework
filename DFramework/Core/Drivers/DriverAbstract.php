<?php

namespace DF\Core\Drivers;

abstract class DriverAbstract
{
    protected $user;
    protected $pass;
    protected $dbName;
    protected $host;

    protected function __construct($user, $pass, $dbName, $host = null) {

    }

    /**
     * @return string
     */
    public abstract function getDsn();
}