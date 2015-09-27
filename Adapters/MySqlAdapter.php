<?php

namespace DF\Adapters;

class MySqlAdapter extends Database {
    protected function connect() {
        self::$connection = new \PDO('mysql:host=$this->host;dbname=$this->dbName;charset=utf8', $this->username, $this->password);
    }

    public function query($query) {
        return self::$connection->query($query);
    }

    public function prepare($query) {
        $statement = self::$connection->prepare($query);

        return new Statement($statement);
    }

    public function execute($data = null) {
        $this->statement->execute($data);

        return $this;
    }

    public function lastId($name = null) {
        return self::$connection->lastInsertId($name);
    }

    public function beginTransaction() {
        return self::$connection->beginTransaction();
    }

    public function commit() {
        return self::$connection->commit();
    }

    public function rollBack() {
        return self::$connection->rollBack();
    }

    public static function getInstance() {
        if (self::$connection == null) {
            self::$connection = new MySqlAdapter();
        }

        return self::$connection;
    }
}