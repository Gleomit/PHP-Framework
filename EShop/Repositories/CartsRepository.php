<?php

namespace DF\Repositories;


use DF\Config\DatabaseConfig;
use DF\Models\Cart;

class CartsRepository implements IRepository
{
    /**
     * @var \DF\Core\Database
     */
    private $db;
    const TABLE_NAME = "usercart";

    public function __construct() {
        $this->db = \DF\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function remove($id) {
    }

    public function findById($id) {
        $statement = $this->db->prepare("
            SELECT
                cp.id as cartProductId,
                c.id,
                u.username,
                p.id as productId,
                p.price,
                p.name
            FROM users u
            JOIN usercart c ON c.user_id = u.id
            JOIN cart_products cp ON cp.cart_id = c.id
            JOIN products p ON cp.product_id = p.id
            WHERE u.id = ?;
        ");

        if(!$statement->execute([$id])) {
            echo $statement->errorInfo();
            return false;
        }

        $statementData = $statement->fetchAll();
        $cartsData = [];

        foreach ($statementData as $cart) {
            $cartItems[] = new Cart($cart);
        }

        return $cartsData;
    }

    public function getProductsInCart($cartId) {
        $statement = $this->db->prepare("
            SELECT
	            p.id, p.name, p.price
            FROM cart_products cp
            JOIN products p ON cp.product_id = p.id
            WHERE cp.cart_id = ?;
        ");

        if(!$statement->execute([$cartId])) {
            echo $statement->errorInfo();
            return false;
        }

        $statementData = $statement->fetchAll();

        return $statementData;
    }
}