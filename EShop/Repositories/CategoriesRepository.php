<?php

namespace DF\Repositories;


use DF\BindingModels\Category\CreateCategoryBindingModel;
use DF\BindingModels\Category\UpdateCategoryBindingModel;
use DF\Config\DatabaseConfig;
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

        if(!$statement->execute()) {
            echo $statement->errorInfo();
            return false;
        }

        $data = $statement->fetchAll();
        $categories = [];

        foreach ($data as $category) {
            $categories[] = new Category($category);
        }

        return $categories;
    }

    public function findById($id) {
        $statement = $this->db->prepare("
            SELECT * FROM categories WHERE id = ?
        ");

        $statement->execute([$id]);

        if($statement->rowCount() <= 0) {
            return null;
        }

        $data = $statement->fetch();

        $category = new Category($data);

        return $category;
    }
}