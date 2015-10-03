<?php

namespace DF\Controllers;


use DF\BindingModels\Product\AddToCartBindingModel;
use DF\BindingModels\Product\ChangeProductCategoryBindingModel;
use DF\BindingModels\Product\ChangeProductQuantityBindingModel;
use DF\BindingModels\Product\CreateProductBindingModel;
use DF\Core\View;
use DF\Helpers\Session;
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
     * @param $id
     * @Authorize
     * @Route("{id:num}/comment")
     */
    public function commentProduct($id) {

    }

    /**
     * @Authorize
     * @Route("{id:num}/add")
     * @POST
     */
    public function addToCard($id) {
        $result = $this->eshopData->getProductsRepository()->addToCart(Session::get('userId'), $id);

    }

    /**
     * @Authorize
     * @Route("{id:num}/add")
     * @POST
     */
    public function removeFromCard($id) {
        $result = $this->eshopData->getProductsRepository()->addToCart(Session::get('userId'), $id);
    }

    /**
     * @POST
     * @Roles(Administrator, Editor)
     * @Route("{id:num}/quantity")
     */
    public function changeQuantity($id, ChangeProductQuantityBindingModel $model) {
        $result = $this->eshopData->getProductsRepository()->changeQuantity($id, $model->getQuantity());


    }

    /**
     * @param $id
     * @Route("{id:num}")
     */
    public function viewProduct($id) {
        $product = $this->eshopData->getProductsRepository()->findById($id);



        return new View('product/productDetails', []);
    }

    /**
     * @DELETE
     * @Roles(Administrator, Editor)
     * @Route("{id:num}")
     */
    public function deleteProduct($id) {

    }

    /**
     * @POST
     * @Roles(Administrator, Editor)
     * @Route("{id:num}")
     */
    public function changeCategory($id, ChangeProductCategoryBindingModel $model) {
        $result = $this->eshopData->getProductsRepository()->changeCategory($id, $model->getCategoryId());

        if($result) {
            RouteService::redirect('products', '', [$id], true);
        }

        return false;
    }
}