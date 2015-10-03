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

        $statement->execute([$id]);

        $cartsData = [];
        $statementData = $statement->fetchAll();

        foreach ($statementData as $cart) {
            $cartItems[] = new Cart($cart);
        }

        return $cartsData;
    }

    public function getProductsInCart($cartId) {
        $statement = $this->db->prepare("
            SELECT
	            p.id, p.name, p.price, p.category_id, cp.quantity
            FROM cart_products cp
            JOIN products p ON cp.product_id = p.id
            WHERE cp.cart_id = ?;
        ");

        $statement->execute([$cartId]);

        $products = [];

        if($statement->rowCount() > 0) {
            $products = $statement->fetchAll();
        }

        return $products;
    }

    public function checkoutCart($userId, $cartId) {
        $products = $this->getProductsInCart($cartId);

        $promoRepo = new PromotionsRepository();

        $this->db->beginTransaction();

        $price = 0;

        foreach($products as $product) {
            $discount = $promoRepo->getTheBiggestPromotion($userId, $product['id'], $product['category_id']);

            $price += ($product['price'] / $discount * 100);
        }

        $statement = $this->db->prepare("
            SELECT cash FROM users WHERE id = ?
        ");

        $statement->execute([$userId]);

        $userCash = $statement->fetch();

        if($price > $userCash) {
            $this->db->rollBack();
            return false;
        }

        $this->db->commit();
        return true;
    }
}