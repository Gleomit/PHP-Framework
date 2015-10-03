<?php

namespace DF\Repositories;


use DF\Config\AppConfig;
use DF\Config\DatabaseConfig;
use DF\Core\Database;

class PromotionsRepository implements IRepository
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function findById($id)
    {
        $statement = $this->db->prepare("
            SELECT * FROM promotions WHERE id = ?
        ");

        $statement->execute([$id]);

        $data = $statement->fetch();

        return $data;
    }

    public function getAllProductsPromotion() {
        $statement = $this->db->prepare("
            SELECT * FROM promotions
            WHERE promotion_type = ?
        ");

        //not implemeted
        AppConfig::PROMOTION_TYPES;
        $statement->execute([]);

    }

    public function getProductPromotion($productId) {
        //need to be implemented
    }

    public function remove($id)
    {

    }
}