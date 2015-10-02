<?php

namespace DF\Services;

use DF\Repositories\CartsRepository;
use DF\Repositories\CategoriesRepository;
use DF\Repositories\ProductsRepository;
use DF\Repositories\UsersRepository;

class EShopData
{
    /**
     * @var ProductsRepository
     */
    private $_productsRepository;

    /**
     * @var CategoriesRepository
     */
    private $_categoriesRepository;

    /**
     * @var UsersRepository
     */
    private $_usersRepository;

    /**
     * @var CartsRepository
     */
    private $_cartsRepository;

    public function __construct() {
        $this->_productsRepository = new ProductsRepository();
        $this->_categoriesRepository = new CategoriesRepository();
        $this->_usersRepository = new UsersRepository();
        $this->_cartsRepository = new CartsRepository();
    }

    /**
     * @return CartsRepository
     */
    public function getCartsRepository()
    {
        return $this->_cartsRepository;
    }

    /**
     * @return ProductsRepository
     */
    public function getProductsRepository()
    {
        return $this->_productsRepository;
    }

    /**
     * @return CategoriesRepository
     */
    public function getCategoriesRepository()
    {
        return $this->_categoriesRepository;
    }

    /**
     * @return UsersRepository
     */
    public function getUsersRepository()
    {
        return $this->_usersRepository;
    }
}