<?php

namespace DF\Controllers;


use DF\BindingModels\User\LoginBindingModel;
use DF\BindingModels\User\RegisterBindingModel;
use DF\Core\View;
use DF\Helpers\Session;
use DF\Services\EShopData;
use DF\Services\RouteService;
use DF\ViewModels\UserCartViewModel;

class AccountController extends BaseController
{
    /**
     * @var EShopData
     */
    private $eshopData;

    const DEFAULT_USER_CASH = 500.00;

    public function __construct() {
        $this->eshopData = new EShopData();
    }

    /**
     * @Authorize
     */
    public function profile() {
        echo $this->eshopData->getPromotionsRepository()->getTheBiggestPromotion(
            Session::get('userId'), 1, 2
        );

        return new View('user/profile', []);
    }

    /**
     * @Authorize
     * @Route("cart/product/{productId:num}/remove")
     */
    public function removeProductFromCart($productId) {
        $cartId = $this->eshopData->getUsersRepository()->getUserCartId(Session::get('userId'))['id'];
        $result = $this->eshopData->getCartsRepository()->removeProduct($productId, $cartId);

        RouteService::redirect('account', 'cart');
    }

    /**
     * @Authorize
     * @Route("cart/product/{productId:num}/increase")
     */
    public function increaseProductQuantityInCart($productId) {
        $cartId = $this->eshopData->getUsersRepository()->getUserCartId(Session::get('userId'))['id'];
        $result = $this->eshopData->getProductsRepository()->increaseQuantityInCart($productId, $cartId);

        RouteService::redirect('account', 'cart');
    }

    /**
     * @Authorize
     * @Route("cart/product/{productId:num}/decrease")
     */
    public function decreaseProductQuantityInCart($productId) {
        $cartId = $this->eshopData->getUsersRepository()->getUserCartId(Session::get('userId'))['id'];
        $result = $this->eshopData->getProductsRepository()->decreaseQuantityInCart($productId, $cartId);

        RouteService::redirect('account', 'cart');
    }

    /**
     * @Authorize
     */
    public function cart() {
        $cartId = $this->eshopData->getUsersRepository()->getUserCartId(Session::get('userId'))['id'];
        $products = $this->eshopData->getCartsRepository()->getProductsInCart($cartId);

        $viewModel = new UserCartViewModel();
        $viewModel->products = $products;

        foreach($viewModel->products as $product) {
            $viewModel->totalSum += $product['price'] * $product['quantity'];
        }

        return new View('user/cart', $viewModel);
    }

    /**
     * @param RegisterBindingModel $model
     * @throws \Exception
     * @POST
     */
    public function register(RegisterBindingModel $model) {
        $model->setCash(self::DEFAULT_USER_CASH);

        $registerResult = $this->eshopData->getUsersRepository()->create($model);

        if($registerResult) {
            $data = [
                "username" => $model->getUsername(),
                "password" => $model->getPassword()
            ];

            $loginDetails = new LoginBindingModel($data);
            $this->login($loginDetails);
        }

        throw new \Exception("Registration error");
    }

    /**
     * @Authorize
     * @POST
     * @Route("cart/checkout")
     */
    public function checkoutCart() {
        $cartId = $this->eshopData->getUsersRepository()->getUserCartId(Session::get('userId'));
        $this->eshopData->getCartsRepository()->checkoutCart(Session::get('userId'), $cartId['id']);
        echo 'haha';
    }

    /**
     * @param LoginBindingModel $model
     * @throws \Exception
     * @POST
     */
    public function login(LoginBindingModel $model) {
        $username = $model->getUsername();
        $password = $model->getPassword();

        $user = $this->eshopData->getUsersRepository()->findByUsername($username);

        if($user === false || !password_verify($password, $user->getPassword())){
            throw new \Exception('Invalid credentials');
        }

        Session::put('userId', $user->getId());
//        Session::put('roles')

        RouteService::redirect('account', 'profile', true);
    }

    /**
     * @Authorize
     */
    public function logout() {
        if($this->isLogged()) {
            Session::emptyUserRelated();
            RouteService::redirect('home', '', true);
        }
    }
}