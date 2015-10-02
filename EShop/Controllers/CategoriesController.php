<?php

namespace DF\Controllers;


use DF\BindingModels\Category\CreateCategoryBindingModel;
use DF\BindingModels\Category\DeleteCategoryBindingModel;
use DF\Core\View;
use DF\Services\EShopData;
use DF\Services\RouteService;

class CategoriesController extends BaseController
{
    /**
     * @var EShopData
     */
    private $eshopData;

    public function __construct() {
        $this->_eshopData = new EShopData();
    }

    public function all() {
        $categories = $this->eshopData->getCategoriesRepository()->all();
        $viewModel = new CategoryViewModel();
        $viewModel->categoryViewModel = $categories;

        return new View("categories/all", $viewModel);
    }

    /**
     * @param CreateCategoryBindingModel $model
     * @Roles(Administrator, Editor)
     */
    public function add(CreateCategoryBindingModel $model) {
        $isCreated = $this->eshopData->getCategoriesRepository()->create($model);

        if($isCreated) {
            RouteService::redirect('categories', 'all', true);
        }

        echo 'Error during create category';
    }

    /**
     * @Roles(Administrator, Editor)
     */
    public function delete(DeleteCategoryBindingModel $model) {
        $isDeleted = $this->eshopData->getCategoriesRepository()->remove($model->getCategoryId());

        if($isDeleted) {
            RouteService::redirect('categories', 'all', true);
        }else {
            echo 'Error during delete category';
        }
    }

    /**
     * @Route("{categoryId:num}/products")
     */
    public function getProducts($categoryId) {
        $userId = $this->getCurrentUserId();
        $userCartId = $this->eshopData->getCartsRepository()->getCartForCurrentUser($userId);
        $products = $this->eshopData->getCategoriesRepository()->getAllProducts($userId, $userCartId, $categoryId);

        $viewModel = new CategoryProductsViewModel();
        $viewModel->productViewModel = $products;

        return new View('category/products', $viewModel);
    }
}