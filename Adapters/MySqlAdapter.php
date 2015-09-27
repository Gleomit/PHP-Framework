<?php

namespace DF\Adapters;

class MySqlAdapter extends Database {

    private static $_instance;
    private $_statement;

    protected function connect() {
        $this->_connection = new \PDO('mysql:host=$this->_host;dbname=$this->_db_name;charset=utf8', $this->_username, $this->_password);
    }

    public function query($query) {
        return $this->_connection->query($query);
    }

    public function prepare($query) {
        $this->_statement = $this->_connection->prepare($query);

        return $this;
    }

    public function execute($data = null) {
        $this->_statement->execute($data);

        return $this;
    }

    public function beginTransaction() {
        return $this->_connection->beginTransaction();
    }

    public function commit() {
        return $this->_connection->commit();
    }

    public static function getInstance() {
        if (static::$_instance == null) {
            static::$_instance = new MySqlAdapter();
        }

        return static::$_instance;
    }
}