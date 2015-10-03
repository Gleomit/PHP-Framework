<?php

namespace DF\Repositories;


use DF\BindingModels\Comment\CreateCommentBindingModel;
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

        if($statement->rowCount() <= 0) {
            return false;
        }

        return true;
    }

    public function remove($id) {

    }

    public function addComment($userId, $productId, CreateCommentBindingModel $commentModel) {
        $statement = $this->db->prepare("
            INSERT INTO comments (comment_data, comment_date, user_id, product_id)
            VALUES (?, NOW(), ?, ?)
        ");

        $data = [
            $commentModel->getCommentText(),
            $userId,
            $productId
        ];

        if(!$statement->execute($data)) {
            echo $statement->errorInfo();
            return false;
        }

        if($statement->rowCount() <= 0) {
            return false;
        }

        return true;
    }

    public function changeCategory($id, $categoryId) {
        $statement = $this->db->prepare("
            UPDATE products
            SET category_id = ?
            WHERE id = ?
        ");

        $statement->execute([$categoryId, $id]);

        if($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function addToCart($userId, $productId) {
        $statement = $this->db->prepare("
            SELECT id from usercart WHERE user_id = ?
        ");

        $statement->execute([$userId]);

        if($statement->rowCount() <= 0) {
            return false;
        }

        $cartId = $statement->fetch();

        $statement = $this->db->prepare("
            INSERT INTO cart_products (cart_id, product_id)
            VALUES (?, ?)
        ");

        $statement->execute([$cartId, $productId]);

        if($statement->rowCount() <= 0) {
            return false;
        }

        return true;
    }

    public function findById($id) {
        $statement = $this->db->prepare("
            SELECT * FROM products WHERE id = ?
        ");

        $statement->execute([$id]);

        $data = $statement->fetch();

        $product = new Product($data);

        return $product;
    }
}