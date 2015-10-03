<?php

namespace DF\BindingModels\Product;

use DF\BindingModels\IBindingModel;

class CreateProductBindingModel implements IBindingModel
{
    private $productName;
    private $productPrice;
    private $categoryId;
    private $quantity;

    public function __construct($bindingModel) {
        if(isset($bindingModel)) {
            $this->setProductName($bindingModel['productName']);
            $this->setProductPrice($bindingModel['productPrice']);
            $this->setCategoryId($bindingModel['categoryId']);
            $this->setQuantity($bindingModel['quantity']);
        }
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    public function getProductPrice()
    {
        return $this->productPrice;
    }

    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
}