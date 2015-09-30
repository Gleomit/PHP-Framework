<?php

namespace DF\Core;

use DF\Adapters\Database;

abstract class BaseModel {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    protected function getDb() {
        return $this->db;
    }
}