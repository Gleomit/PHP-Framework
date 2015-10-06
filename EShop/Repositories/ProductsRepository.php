<?php

namespace DF\Repositories;

use DF\BindingModels\Comment\CreateCommentBindingModel;
use DF\BindingModels\Product\CreateProductBindingModel;
use DF\Config\DatabaseConfig;
use DF\Helpers\Session;
use DF\Models\Product;

class ProductsRepository implements IRepository
{
    private $db;
    const TABLE_NAME = "products";

    public function __construct()
    {
        $this->db = \DF\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function create(CreateProductBindingModel $model)
    {
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

    public function remove($id)
    {

    }

    public function addComment($userId, $productId, CreateCommentBindingModel $commentModel)
    {
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

    public function changeCategory($id, $categoryId)
    {
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

    public function getAllProducts()
    {
        $statement = $this->db->prepare("
            SELECT * FROM products
        ");

        $statement->execute();

        $products = $statement->fetchAll();

        $promoRepo = new PromotionsRepository();

        for($i = 0; $i < count($products); $i++) {
            $discount = $promoRepo->getTheBiggestPromotion(Session::get('userId'), $products[$i]['id'], $products[$i]['category_id']);

            $products[$i]['original_price'] = $products[$i]['price'];
            $products[$i]['price'] = $products[$i]['price'] - ($products[$i]['price'] * $discount / 100);
            $products[$i]['discount'] = $discount;
        }

        return $products;
    }

    public function changeQuantity($id, $quantity)
    {
        if($quantity < 0) {
            throw new \Exception("Cannot set negative quantity");
        }

        $statement = $this->db->prepare("
            UPDATE products
            SET quantity = ?
            WHERE id = ?
        ");

        $statement->execute([$quantity, $id]);

        if($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function increaseQuantityInCart($productId, $cartId)
    {
        $statement = $this->db->prepare("
            UPDATE cart_products
            SET quantity = quantity + 1
            WHERE product_id = ? AND cart_id = ?
        ");

        $statement->execute([$productId, $cartId]);


        if($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function decreaseQuantityInCart($productId, $cartId)
    {
        $statement = $this->db->prepare("
            UPDATE cart_products
            SET quantity = quantity - 1
            WHERE product_id = ? AND cart_id = ? AND quantity > 0
        ");

        $statement->execute([$productId, $cartId]);


        if($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function addToCart($userId, $productId)
    {
        $statement = $this->db->prepare("
            SELECT id from usercart WHERE user_id = ?
        ");

        $statement->execute([$userId]);

        if($statement->rowCount() <= 0) {
            return false;
        }

        $cartId = $statement->fetch();

        $statement = $this->db->prepare("
            SELECT product_id FROM cart_products WHERE product_id = ?
        ");

        $statement->execute([$productId]);

        if($statement->rowCount() > 0) {
            return false;
        }

        $statement = $this->db->prepare("
            INSERT INTO cart_products (cart_id, product_id, quantity)
            VALUES (?, ?, 1)
        ");

        $statement->execute([$cartId['id'], $productId]);

        if($statement->rowCount() <= 0) {
            return false;
        }

        return true;
    }

    public function getComments($id)
    {
        $statement = $this->db->prepare("
            SELECT c.id, c.comment_data, c.comment_date, u.username FROM comments AS c
            INNER JOIN users AS u ON u.id = c.user_id
            WHERE c.product_id = ?
        ");

        $statement->execute([$id]);

        $comments = [];

        if($statement->rowCount() > 0) {
            $comments = $statement->fetchAll();
        }

        return $comments;
    }

    public function findById($id)
    {
        $statement = $this->db->prepare("
            SELECT * FROM products WHERE id = ?
        ");

        $statement->execute([$id]);

        $data = $statement->fetch();

        return $data;
    }
}