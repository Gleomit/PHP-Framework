<?php

namespace DF\Models;

class Cart
{
    private $_id;
    private $_cartOwner;
    private $_cartProductId;
    private $_productId;
    private $_productName;
    private $_productPrice;

    public function __construct($data)
    {
        $this->setId($data['id']);
        $this->setCartOwner($data['username']);
        $this->setProductId($data['productId']);
        $this->setProductName($data['name']);
        $this->setProductPrice($data['price']);
        $this->setCartProductId($data['cartProductId']);
    }

    public function getCartProductId()
    {
        return $this->_cartProductId;
    }

    public function setCartProductId($cartProductId)
    {
        $this->_cartProductId = $cartProductId;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getCartOwner()
    {
        return $this->_cartOwner;
    }

    public function setCartOwner($cartOwner)
    {
        $this->_cartOwner = $cartOwner;
    }

    public function getProductId()
    {
        return $this->_productId;
    }

    public function setProductId($productId)
    {
        $this->_productId = $productId;
    }

    public function getProductName()
    {
        return $this->_productName;
    }

    public function setProductName($productName)
    {
        $this->_productName = $productName;
    }

    public function getProductPrice()
    {
        return $this->_productPrice;
    }

    public function setProductPrice($productPrice)
    {
        $this->_productPrice = $productPrice;
    }
}