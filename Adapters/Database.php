<?php

namespace DF\Adapters;

abstract class Database {
    protected $_host;
    protected $_username;
    protected $_password;

    protected $_db_name;
    protected $_connection;

    public function __construct($host, $user, $pass, $db) {
        $this->_host = $host;
        $this->_username = $user;
        $this->_password = $pass;
        $this->_db_name = $db;

        $this->connect();
        $this->query("SET NAMES utf8");
    }

    abstract protected function connect();
    abstract public function query($query);
}
