<?php

namespace DF\BindingModels\Product;


use DF\BindingModels\IBindingModel;

class AddToCartBindingModel implements IBindingModel
{
    private $productId;

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($value) {
        $this->productId = $value;
    }
}