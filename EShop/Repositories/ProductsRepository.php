<?php

namespace DF\Repositories;


use DF\BindingModels\Product\CreateProductBindingModel;
use DF\Config\DatabaseConfig;
use DF\Models\Product;

class ProductsRepository implements IRepository
{
    private $db;
    const TABLE_NAME = "products";

    public function __construct() {
        $this->db = \DF\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function create(CreateProductBindingModel $model) {
        $statement = $this->db->prepare("
            INSERT INTO products (name, category_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");

        $data = [
            $model->getProductName(),
            $model->getCategoryId(),
            $model->getQuantity(),
            $model->getProductPrice()
        ];

        if(!$statement->execute($data)) {
            echo $statement->errorInfo();
            return false;
        }

        return true;
    }

    public function remove($id) {

    }

    public function findById($id) {
        $data = $this->db->getEntityById(self::TABLE_NAME, $id);

        if($data == null) {
            throw new \Exception("Product with such id does not exists");
        }

        $product = new Product($data);

        return $product;
    }
}