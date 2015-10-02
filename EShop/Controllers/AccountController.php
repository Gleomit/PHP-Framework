<?php

namespace DF\Controllers;


use DF\BindingModels\User\LoginBindingModel;
use DF\BindingModels\User\RegisterBindingModel;
use DF\Config\AppConfig;
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
        $this->_eshopData = new EShopData();
    }

    public function profile() {
        if(!$this->isLogged()) {
            RouteService::redirect('home', 'login', true);
        }

        $currentUser = $this->_eshopData->getUsersRepository()->findById($this->getCurrentUserId());

        if($currentUser != null) {
            $viewModel = new ProfileViewModel();
            $viewModel->userViewModel = $currentUser;
//            $viewModel->userViewModel->setRoleName(AppUserRolesConfig::getUserRoleName($currentUser->getRole()));

            $viewModel->render();
        }
    }

    public function register(RegisterBindingModel $model) {
        $model->setCash(self::DEFAULT_USER_CASH);
        $model->setRole(AppConfig::DEFAULT_USER_ROLE);

        $registerResult = $this->eshopData->getUsersRepository()->create($model);

        if($registerResult != false) {
            $data = [
                "username" => $model->getUsername(),
                "password" => $model->getPassword()
            ];

            $loginDetails = new LoginBindingModel($data);
            $this->login($loginDetails);
        }

        throw new \Exception("Registration error");
    }

    public function login(LoginBindingModel $model) {
        $username = $model->getUsername();
        $password = $model->getPassword();

        $user = $this->eshopData->getUsersRepository()->findByUsername($username);

        if($user == null || !password_verify($password, $user->getPassword())){
            throw new \Exception('Invalid credentials');
        }

        Session::put('userId', $user->getId());
        Session::put('role', $user->getRole()); //Not finished, need to get role name by app config

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