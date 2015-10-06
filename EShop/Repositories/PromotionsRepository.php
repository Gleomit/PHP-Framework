<?php

namespace DF\Repositories;

use DF\Config\AppConfig;
use DF\Config\DatabaseConfig;
use DF\Core\Database;

class PromotionsRepository implements IRepository
{
    private $db;

    public function __construct()
    {
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

    public function getBiggestGlobalPromotion()
    {
        $statement = $this->db->prepare("
            SELECT id, start_date, end_date, promotion_type, MAX(discount) AS discount FROM promotions
            WHERE promotion_type = ? AND end_date > NOW() AND NOW() > start_date
        ");

        $statement->execute([AppConfig::$PROMOTION_TYPES['All Products']]);

        $result = null;

        if($statement->rowCount() > 0) {
            $result = $statement->fetch();
        }

        return $result;
    }

    public function getCategoryPromotion($categoryId)
    {
        $statement = $this->db->prepare("
            SELECT p.id, p.start_date, p.end_date, p.promotion_type, MAX(p.discount) AS discount FROM promotions AS p
            INNER JOIN category_promotions AS cp ON cp.promotion_id = p.id
            WHERE cp.category_id = ? AND p.promotion_type = ? AND p.end_date > NOW() AND NOW() > p.start_date
        ");

        $statement->execute([
            $categoryId,
            AppConfig::$PROMOTION_TYPES['Certain Categories']
        ]);

        $result = null;

        if($statement->rowCount() > 0) {
            $result = $statement->fetch();
        }

        return $result;
    }

    public function getProductPromotion($productId)
    {
        $statement = $this->db->prepare("
            SELECT p.id, p.start_date, p.end_date, p.promotion_type, MAX(p.discount) AS discount FROM promotions AS p
            INNER JOIN products_promotions AS pp ON pp.promotion_id = p.id
            WHERE pp.product_id = ? AND p.promotion_type = ? AND p.end_date > NOW() AND NOW() > p.start_date
        ");

        $statement->execute([
            $productId,
            AppConfig::$PROMOTION_TYPES['Certain Products']
        ]);

        $result = null;

        if($statement->rowCount() > 0) {
            $result = $statement->fetch();
        }

        return $result;
    }

    public function getUserPromotion($userId)
    {
        $statement = $this->db->prepare("
            SELECT cash FROM users WHERE id = ?
        ");

        $statement->execute([$userId]);

        $data = $statement->fetch();

        $statement = $this->db->prepare("
            SELECT p.id, p.start_date, p.end_date, p.promotion_type, MAX(p.discount) AS discount FROM promotions AS p
            INNER JOIN user_criteria_promotions AS ucp ON ucp.promotion_id = p.id
            WHERE ucp.min_cash <= ? AND p.promotion_type = ? AND p.end_date > NOW() AND NOW() > p.start_date
        ");

        $statement->execute([
            $data['cash'],
            AppConfig::$PROMOTION_TYPES['User Criteria']
        ]);

        $result = null;

        if($statement->rowCount() > 0) {
            $result = $statement->fetch();
        }

        return $result;
    }

    public function getTheBiggestPromotion($userId = null, $productId = null, $categoryId = null)
    {
        $discount = 0;

        $globalPromotion = $this->getBiggestGlobalPromotion();
        $categoryPromotion = $this->getCategoryPromotion($categoryId);
        $productPromotion = $this->getProductPromotion($productId);
        $userBasedDiscount = $this->getUserPromotion($userId);

        if($globalPromotion != null) {
            $discount = $globalPromotion['discount'];
        }

        if($categoryPromotion != null) {
            $discount = max($discount, $categoryPromotion['discount']);
        }

        if($productPromotion != null) {
            $discount = max($discount, $productPromotion['discount']);
        }

        if($userBasedDiscount != null) {
            $discount = max($discount, $userBasedDiscount['discount']);
        }

        return $discount;
    }

    public function remove($id)
    {

    }
}