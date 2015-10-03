<?php

namespace DF\Controllers;


use DF\App;
use DF\BindingModels\User\LoginBindingModel;
use DF\BindingModels\User\RegisterBindingModel;
use DF\Config\AppConfig;
use DF\Core\View;
use DF\Helpers\Session;
use DF\Services\EShopData;
use DF\Services\RouteService;

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
        return new View('user/profile', []);
    }

    /**
     * @Authorize
     */
    public function cart() {

        return new View('user/cart', []);
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

        RouteService::redirect('account', 'profile', true);
    }

    /**
     * @Authorize
     */
    public function logout() {
        if($this->isLogged()) {
            Session::emptyUserRelated();
            RouteService::redirect('home', 'index', true);
        }
    }
}