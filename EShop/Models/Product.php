<?php

namespace DF\Models;


class Product extends BaseModel
{
    private $_id;
    private $_name;
    private $_categoryId;
    private $_quantity;
    private $_price;
    private $_categoryName;

    public function __construct($data) {
        $this->setId($data['id']);
        $this->setName($data['name']);
        $this->setCategoryId($data['category_id']);
//        $this->setCategoryName($data['categoryName']);
        $this->setQuantity($data['quantity']);
        $this->setPrice($data['price']);
    }

    public function getCategoryName() {
        return $this->_categoryName;
    }

    public function setCategoryName($categoryName) {
        $this->_categoryName = $categoryName;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getCategoryId() {
        return $this->_categoryId;
    }

    public function setCategoryId($categoryId) {
        $this->_categoryId = $categoryId;
    }

    public function getQuantity() {
        return $this->_quantity;
    }

    public function setQuantity($quantity) {
        $this->_quantity = $quantity;
    }

    public function getPrice() {
        return $this->_price;
    }

    public function setPrice($price) {
        $this->_price = $price;
    }
}