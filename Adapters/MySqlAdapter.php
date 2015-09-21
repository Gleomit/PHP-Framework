<?php

namespace DF\Adapters;

class MySqlAdapter extends Database {

    private static $_instance;
    private $_result;

    protected function connect() {
        $this->_conn = new \PDO('mysql:host=localhost;dbname=testdb;charset=utf8', 'username', 'password');
    }

    public function query($query) {
        return $this->_conn->query($query);
    }

    public function prepare($query) {
        $this->_result = $this->_conn->prepare($query);
        return $this;
    }

    public function execute() {
        $this->_result->execute();
        return $this;
    }

    public function executeWithData($data) {
        $this->_result->execute($data);
        return $this;
    }

    public function beginTransaction() {
        return $this->_conn->beginTransaction();
    }

    public function commit() {
        return $this->_conn->commit();
    }

    public static function getInstance() {
        if (static::$_instance == null) {
            static::$_instance = new MySqlAdapter();
        }

        return static::$_instance;
    }
}