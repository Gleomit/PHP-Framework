<?php

namespace DF\Controllers;

use DF\BindingModels\Comment\CreateCommentBindingModel;
use DF\BindingModels\Product\ChangeProductCategoryBindingModel;
use DF\BindingModels\Product\ChangeProductQuantityBindingModel;
use DF\BindingModels\Product\CreateProductBindingModel;
use DF\Core\View;
use DF\Helpers\Session;
use DF\Services\EShopData;
use DF\Services\RouteService;
use DF\ViewModels\ProductViewModel;

class ProductsController extends BaseController
{
    /**
     * @var EShopData
     */
    private $eshopData;

    public function __construct()
    {
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
            RouteService::redirect('categories', '', true);
        }

        echo "Unable to add product";
    }

    /**
     * @param $id
     * @Authorize
     * @Route("{id:num}/comment")
     * @POST
     */
    public function commentProduct($id, CreateCommentBindingModel $model)
    {
        $this->eshopData->getProductsRepository()->addComment(Session::get('userId'), $id, $model);

        header('Location: ' . RouteService::$basePath . '/products/' . $id);
        exit;
    }

    /**
     * @Authorize
     * @Route("{id:num}/add")
     */
    public function addToCart($id)
    {
        $result = $this->eshopData->getProductsRepository()->addToCart(Session::get('userId'), $id);

        RouteService::redirect('categories', '',[], true);
    }

    /**
     * @POST
     * @Roles(Administrator, Editor)
     * @Route("{id:num}/quantity")
     */
    public function changeQuantity($id, ChangeProductQuantityBindingModel $model)
    {
        $result = $this->eshopData->getProductsRepository()->changeQuantity($id, $model->getQuantity());

        RouteService::redirect('products', '', [$id], true);
    }

    /**
     * @param $id
     * @Route("{id:num}")
     */
    public function viewProduct($id)
    {
        $product = $this->eshopData->getProductsRepository()->findById($id);
        $comments = $this->eshopData->getProductsRepository()->getComments($id);

        $viewModel = new ProductViewModel();

        $viewModel->product = $product;
        $viewModel->comments = $comments;

        return new View('product/productDetails', $viewModel);
    }

    /**
     * @DELETE
     * @Roles(Administrator, Editor)
     * @Route("{id:num}")
     */
    public function deleteProduct($id)
    {

    }

    /**
     * @POST
     * @Roles(Administrator, Editor)
     * @Route("{id:num}")
     */
    public function changeCategory($id, ChangeProductCategoryBindingModel $model)
    {
        $result = $this->eshopData->getProductsRepository()->changeCategory($id, $model->getCategoryId());

        RouteService::redirect('products', '', [$id], true);
    }
}