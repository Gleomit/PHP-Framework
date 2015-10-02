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
        $isCreated = $this->db->insertEntity(self::TABLE_NAME, array(
            'name' =>$model->getProductName(),
            'category_id' =>$model->getCategoryId(),
            'quantity' =>$model->getQuantity(),
            'price' =>$model->getProductPrice()
        ));

        return $isCreated;
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