<?php

namespace DF\Repositories;


use DF\Config\DatabaseConfig;
use DF\Core\Database;

class CommentsRepository implements IRepository
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function findById($id)
    {
        $statement = $this->db->prepare("
            SELECT * FROM comments WHERE id = ?
        ");

        $statement->execute([$id]);

        $result = null;

        if($statement->rowCount() > 0) {
            $result = $statement->fetch();
        }

        return result;
    }

    public function remove($id)
    {
        $statement = $this->db->prepare("
            DELETE FROM comments WHERE id = ?
        ");

        if(!$statement->execute([$id])) {
            echo $statement->errorInfo();
            return false;
        }

        return true;
    }
}