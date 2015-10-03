<?php

namespace DF\BindingModels\Category;


use DF\BindingModels\IBindingModel;

class CreateCategoryBindingModel implements IBindingModel
{
    private $name;
    protected $products = [];

    public function __construct($data) {
        if(isset($data)) {
            $this->setName($data['name']);
        }
//        $this->setProducts($data['products']);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getProducts() {
        return $this->products;
    }

    public function setProducts($products) {
        $this->products = $products;
    }
}