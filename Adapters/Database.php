<?php

namespace DF\Adapters;

use DF\Config\DatabaseConfig;

abstract class Database {
    protected $host;
    protected $username;
    protected $password;

    protected $dbName;
    protected static $connection;

    public function __construct($host = DatabaseConfig::HOST, $username = DatabaseConfig::USER,
                                $password = DatabaseConfig::PASSWORD, $dbName = DatabaseConfig::DATABASE_NAME) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;

        $this->connect();
        $this->query("SET NAMES utf8");
    }

    abstract protected function connect();
    abstract public function query($query);
}
