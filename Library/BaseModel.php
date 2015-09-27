<?php

namespace DF\Library;

abstract class BaseModel {
    private $db;

    public function __construct( $db) {
        $this->db = $db;
    }

    protected function getDb() {
        return $this->db;
    }
}