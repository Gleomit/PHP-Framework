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
        $this->db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    }

    /**
     * @param string $instanceName
     * @return Database
     * @throws \Exception
     */
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

    public function getEntityByColumnName($fromTable, $columnName, $columnValue) {
        $statement = $this->prepare("
            SELECT * FROM $fromTable
            WHERE $columnName = ?;
        ");

        if(!$statement->execute([$columnValue])) {
            echo $statement->errorInfo();
            return false;
        }

        return $statement->fetch();
    }

    public function getEntityById($fromTable, $id) {
        $statement = $this->prepare("
            SELECT * FROM $fromTable WHERE id = ?
        ");

        if(!$statement->execute([$id])) {
            echo $statement->errorInfo();
            return false;
        }

        return $statement->fetch();
    }

    public function getAllEntitiesByColumnName($fromTable, $columnName, $columnValue, $limit = null, $offset = null) {
        $data = [$columnName];
        $statement = $this->prepare(" SELECT * FROM $fromTable WHERE $columnName = ?");

        if($limit && $offset) {
            $statement = $this->prepare("
            SELECT * FROM $fromTable WHERE $columnName = ? LIMIT ? OFFSET ?");

            $data[] = $limit;
            $data[] = $offset;
        }

        if(!$statement->execute($data)) {
            echo $statement->errorInfo();
            return false;
        }

        return $statement->fetchAll();
    }

    public function getAllEntities($fromTable, $limit = null, $offset = null) {
        $statement = $this->prepare(" SELECT * FROM $fromTable ");
        $data = [];

        if($limit && $offset) {
            $statement = $this->prepare("
                SELECT * FROM $fromTable LIMIT ? OFFSET ?
            ");

            $data = [$limit, $offset];
        }

        if(!$statement->execute($data)) {
            echo $statement->errorInfo();
            return false;
        }

        return $statement->fetchAll();
    }

    public function insertEntity($inTable, $entityData) {
        $valuesCount = $this->getValuesCount($entityData);
        $columnNames = implode(', ', array_keys($entityData));
        $statement = $this->prepare("
            INSERT INTO $inTable ($columnNames) VALUES($valuesCount)
        ");

        $this->beginTransaction();

        if(!$statement->execute(array_values($entityData))) {
            echo $statement->errorInfo();
            $this->rollBack();
            return false;
        }

        $this->commit();
        return true;
    }

    public function updateEntityById($tableName, $entityData, $id)
    {
        $valuesCount = $this->getValuesCount($entityData);
        $columnNames = implode(', ', array_keys($entityData));
        $statement = $this->prepare("
            UPDATE $tableName SET $columnNames = $valuesCount WHERE id = ?
        ");

        $params = [];

        array_push($entityData, $id);
        array_push($params, array_values($entityData));

        $this->beginTransaction();

        if(!$statement->execute($params[0])) {
            echo $statement->errorInfo();
            $this->rollBack();
            return false;
        }

        $this->commit();
        return true;
    }

    public function deleteEntityById($tableName, $id) {
        $statement = $this->prepare("
            DELETE FROM $tableName WHERE id = ?
        ");

        $this->beginTransaction();

        if(!$statement->execute( [ $id ] )) {
            echo $statement->errorInfo();
            $this->rollBack();
            return false;
        }

        $this->commit();
        return true;
    }

    private function getValuesCount($assoc) {
        $keys = array_values($assoc);
        $columns = '';

        foreach ($keys as $k) {
            $columns .= '?, ';
        }

        return substr($columns, 0, strlen($columns) - 2);
    }
}