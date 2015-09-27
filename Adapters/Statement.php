<?php

namespace DF\Adapters;

class Statement
{
    /**
     * @var \PDOStatement
     */
    private $statement;

    public function __construct(\PDOStatement $statement) {
        $this->statement = $statement;
    }

    public function fetch($fetchStyle = \PDO::FETCH_ASSOC) {
        return $this->statement->fetch($fetchStyle);
    }

    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC) {
        return $this->statement->fetchAll($fetchStyle);
    }

    public function bindParam($parameter, &$variable, $dataType = \PDO::PARAM_STMT,
                              $length, array $driverOptions = []) {
        return $this->statement->bindParam($parameter, $variable, $dataType, $length, $driverOptions);
    }

    public function execute($data = null) {
        return $this->statement->execute($data);
    }

    public function rowCount() {
        return $this->statement->rowCount();
    }
}