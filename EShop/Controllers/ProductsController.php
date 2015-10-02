<?php

namespace DF\Controllers;


use DF\BindingModels\Product\CreateProductBindingModel;
use DF\Services\EShopData;
use DF\Services\RouteService;

class ProductsController extends BaseController
{
    /**
     * @var EShopData
     */
    private $eshopData;

    public function __construct() {
        $this->eshopData = new EShopData();
    }

    public function addProduct(CreateProductBindingModel $model)
    {
        $isAdded = $this->eshopData->getProductsRepository()->create($model);

        if($isAdded) {
            RouteService::redirect('categories', 'all', true);
        }

        echo "Unable to add product";
    }
}