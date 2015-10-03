<?php

namespace DF\BindingModels\Product;


use DF\BindingModels\IBindingModel;

class ChangeProductQuantityBindingModel implements IBindingModel
{
    private $quantity;

    public function __construct() {

    }

    public function setQuantity($value) {
        $this->quantity = $value;
    }

    public function getQuantity() {
        return $this->quantity;
    }
}