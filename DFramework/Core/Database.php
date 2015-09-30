<?php

namespace DF\Core;

use DF\Core\Drivers\DriverFactory;

class Database
{
    private static $_instances = array();

    /**
     * @var \PDO
     */
    private $db;

    private function __construct ($pdoInstance) {
        $this->db = $pdoInstance;
    }

    public static function getInstance ($instanceName = 'default') {
        if(!isset(self::$_instances[$instanceName])) {
            throw new \Exception("Instance with this name does not exists.");
        }

        return static::$_instances[$instanceName];
    }

    public static function setInstance ($instanceName, $driver, $user, $pass, $dbName, $host = null) {
        $driver = DriverFactory::create($driver, $user, $pass, $dbName, $host);

        $pdo = new \PDO($driver->getDsn(), $user, $pass);

        self::$_instances[$instanceName] = new self($pdo);
    }

    public function prepare($statement, array $driverOptions = []) {
        $statement = $this->db->prepare($statement, $driverOptions);

        return new Statement($statement);
    }

    public function query($query) {
        return $this->db->query($query);
    }

    public function lastId($name = null) {
        return $this->db->lastInsertId($name);
    }

    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    public function commit() {
        return $this->db->commit();
    }

    public function rollBack() {
        return $this->db->rollBack();
    }
}