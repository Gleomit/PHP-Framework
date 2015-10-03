<?php

namespace DF\Controllers;


use DF\BindingModels\Category\CreateCategoryBindingModel;
use DF\BindingModels\Category\DeleteCategoryBindingModel;
use DF\Core\View;
use DF\Services\EShopData;
use DF\Services\RouteService;
use DF\ViewModels\CategoryViewModel;

class CategoriesController extends BaseController
{
    /**
     * @var EShopData
     */
    private $eshopData;

    public function __construct() {
        $this->eshopData = new EShopData();
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
     * @Route("")
     * @POST
     */
    public function add(CreateCategoryBindingModel $model) {
        $isCreated = $this->eshopData->getCategoriesRepository()->create($model);

        if($isCreated) {
            RouteService::redirect('categories', '', true);
        }

        echo 'Error during create category';
    }

    /**
     * @Roles(Administrator, Editor)
     */
    public function delete(DeleteCategoryBindingModel $model) {
        $isDeleted = $this->eshopData->getCategoriesRepository()->remove($model->getCategoryId());

        if($isDeleted) {
            RouteService::redirect('categories', '', true);
        }else {
            echo 'Error during delete category';
        }
    }

    /**
     * @Route("{categoryId:num}/products")
     */
    public function getProducts($categoryId) {
        $products = $this->eshopData->getCategoriesRepository()->findById($categoryId);

        $viewModel = new CategoryViewModel();

        $viewModel->products = $products;

        return new View('category/products', $viewModel);
    }
}