<?php

namespace DF\Repositories;


use DF\BindingModels\Category\CreateCategoryBindingModel;
use DF\BindingModels\Category\UpdateCategoryBindingModel;
use DF\Config\DatabaseConfig;
use DF\Helpers\Session;
use DF\Models\Category;

class CategoriesRepository implements IRepository
{
    private $db;
    const TABLE_NAME = "categories";

    public function __construct() {
        $this->db = \DF\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function create(CreateCategoryBindingModel $model) {
        $statement = $this->db->prepare("
            INSERT INTO categories (name)
            VALUES (?)
        ");

        if(!$statement->execute([$model->getName()])) {
            echo $statement->errorInfo();
            return false;
        }

        if($statement->rowCount() <= 0) {
            return false;
        }

        return true;
    }

    public function update($categoryId, UpdateCategoryBindingModel $model) {
        $statement = $this->db->prepare("
            UPDATE categories
            SET name = ?
            WHERE id = ?
        ");

        if(!$statement->execute([$model->getName(), $categoryId])) {
            echo $statement->errorInfo();
            return false;
        }

        if($statement->rowCount() <= 0) {
            return false;
        }

        return true;
    }

    public function remove($categoryId) {
        $statement = $this->db->prepare("
            DELETE FROM categories
            WHERE id = ?
        ");

        if(!$statement->execute([$categoryId])) {
            echo $statement->errorInfo();
            return false;
        }

        return true;
    }

    public function getCategories() {
        $statement = $this->db->prepare("
            SELECT * FROM categories
        ");

        $statement->execute();

        $data = $statement->fetchAll();
        $categories = $data;

        return $categories;
    }

    public function findById($id) {
        $statement = $this->db->prepare("
            SELECT * FROM categories WHERE id = ?
        ");

        $statement->execute([$id]);

        $category = null;

        if($statement->rowCount() > 0) {
            $data = $statement->fetch();
            $category = new Category($data);
        }

        return $category;
    }

    public function getProducts($categoryId) {
        $statement = $this->db->prepare("
            SELECT * FROM products WHERE category_id = ?
        ");

        $statement->execute([$categoryId]);

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
}