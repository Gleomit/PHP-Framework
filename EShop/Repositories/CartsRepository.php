<?php

namespace DF\Repositories;

use DF\Config\DatabaseConfig;
use DF\Helpers\Session;
use DF\Models\Cart;

class CartsRepository implements IRepository
{
    /**
     * @var \DF\Core\Database
     */
    private $db;

    public function __construct()
    {
        $this->db = \DF\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function remove($id)
    {
    }

    public function findById($id)
    {
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

    public function getProductsInCart($cartId)
    {
        $statement = $this->db->prepare("
            SELECT
	            p.id, p.name, p.price, p.category_id, cp.quantity, p.quantity AS product_max_quantity, p.details
            FROM cart_products cp
            JOIN products p ON cp.product_id = p.id
            WHERE cp.cart_id = ?;
        ");

        $statement->execute([$cartId]);

        $products = [];

        if($statement->rowCount() > 0) {
            $products = $statement->fetchAll();
        }

        $promoRepo = new PromotionsRepository();

        for($i = 0; $i < count($products); $i++) {
            $discount = $promoRepo->getTheBiggestPromotion(Session::get('userId'), $products[$i]['id'], $products[$i]['category_id']);

            $products[$i]['original_price'] = $products[$i]['price'];
            $products[$i]['price'] = $products[$i]['price'] - ($products[$i]['price'] * $discount / 100);
            $products[$i]['discount'] = $discount;
        }

        return $products;
    }

    public function removeProduct($productId, $cartId)
    {
        $statement = $this->db->prepare("
            DELETE FROM cart_products
            WHERE cart_id = ? AND product_id = ?
        ");

        $statement->execute([$cartId, $productId]);

        if($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function checkoutCart($userId, $cartId)
    {
        $products = $this->getProductsInCart($cartId);

        $promoRepo = new PromotionsRepository();

        $this->db->beginTransaction();

        $price = 0;

        foreach($products as $product) {
            if($product['quantity'] > $product['product_max_quantity']) {
                $this->db->rollBack();
                throw new \Exception("Product quantity");
            }

            $discount = $promoRepo->getTheBiggestPromotion($userId, $product['id'], $product['category_id']);

            $price += $product['price'] * $product['quantity'] - ($product['price'] * $product['quantity'] * $discount / 100);

            $statement = $this->db->prepare("
                UPDATE products
                SET quantity = quantity - ?
                WHERE id = ?
            ");

            $statement->execute([
                $product['quantity'],
                $product['id']
            ]);
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

        $statement = $this->db->prepare("
            UPDATE users
            SET cash = cash - ?
            WHERE id = ?
        ");

        $statement->execute([$price, $userId]);

        if($statement->rowCount() <= 0) {
            $this->db->rollBack();
            return false;
        }

        $statement = $this->db->prepare("
            DELETE FROM cart_products
            WHERE cart_id = ?
        ");

        $statement->execute([$cartId]);

        if($statement->rowCount() < 0) {
            $this->db->rollBack();
            return false;
        }


        foreach($products as $product) {
            $statement = $this->db->prepare("
                INSERT INTO user_products (user_id, name, quantity, details, price)
                VALUES (?, ?, ?, ?, ?)
            ");

            $statement->execute([$userId, $product['name'], $product['quantity'], $product['details'], $product['price']]);

            if($statement->rowCount() < 0) {
                $this->db->rollBack();
                return false;
            }
        }

        $this->db->commit();
        return true;
    }
}