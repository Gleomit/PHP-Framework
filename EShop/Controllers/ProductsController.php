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

    /**
     * @param CreateProductBindingModel $model
     * @POST
     * @Roles(Administrator, Editor)
     * @Route("")
     */
    public function addProduct(CreateProductBindingModel $model)
    {
        $isAdded = $this->eshopData->getProductsRepository()->create($model);

        if($isAdded) {
            RouteService::redirect('categories', 'all', true);
        }

        echo "Unable to add product";
    }

    /**
     * @Authorize
     * @Route("{id:num}/add")
     * @POST
     */
    public function addToCard($id) {

    }

    /**
     * @PUT
     * @Roles(Administrator, Editor)
     * @Route("{id:num}/quantity")
     */
    public function changeQuantity($id) {

    }

    /**
     * @DELETE
     * @Roles(Administrator, Editor)
     * @Route("{id:num}")
     */
    public function deleteProduct($id) {

    }

    /**
     * @PUT
     * @Roles(Administrator, Editor)
     * @Route("{id:num}")
     */
    public function changeCategory($id) {

    }
}