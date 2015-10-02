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
        $isCreated = $this->db->insertEntity(self::TABLE_NAME, array(
            'name' => $model->getName()
        ));

        return $isCreated;
    }

    public function update($id, UpdateCategoryBindingModel $model) {
        $isUpdated = $this->db->updateEntityById(
            self::TABLE_NAME,
            array('name' => $model->getName()),
            $id
        );

        return $isUpdated;
    }

    public function remove($id) {
        $category = $this->findById($id);

        if($category == null) {
            throw new \Exception("Category with such id does not exist");
        }

        $isDeleted = $this->db->updateEntityById(
            self::TABLE_NAME,
            array('isDeleted' => 1),
            $id
        );

        return $isDeleted;
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
        $data = $this->db->getEntityById(self::TABLE_NAME, $id);

        if($data == null) {
            return null;
        }

        $category = new Category($data);

        return $category;
    }
}