<?php

namespace DF\Models;


class Category extends BaseModel
{
    private $_id;
    private $_name;
    private $_products = [];

    public function __construct($data) {
        $this->setId($data['id']);
        $this->setName($data['name']);
        $this->setProducts($data['products']);
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

    public function getProducts() {
        return $this->_products;
    }

    public function setProducts($products) {
        $this->_products = $products;
    }
}