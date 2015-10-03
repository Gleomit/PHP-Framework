<?php

namespace DF\BindingModels\Product;


use DF\BindingModels\IBindingModel;

class ChangeProductCategoryBindingModel implements IBindingModel
{
    private $categoryId;

    public function __construct() {

    }

    public function setCategoryId($value) {
        $this->categoryId = $value;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }
}