<?php

namespace DF\Controllers;

use DF\BindingModels\Ban\BanIpBindingModel;
use DF\BindingModels\Ban\BanUserBindingModel;
use DF\Core\View;
use DF\Services\EShopData;
use DF\Services\RouteService;

class AdminController extends BaseController
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
     * @Roles(Administrator)
     */
    public function ban()
    {
        return new View('admin/ban', []);
    }

    /**
     * @POST
     * @Roles(Administrator)
     */
    public function banuser(BanUserBindingModel $model)
    {
        $userExists = $this->eshopData->getUsersRepository()->userExistsByUsername($model->getUsername());

        if(!$userExists) {
            return new View('404', null);
        }

        $this->eshopData->getUsersRepository()->banByUsername($model->getUsername());

        RouteService::redirect('admin', 'ban', [], true);
    }

    /**
     * @POST
     * @Roles(Administrator)
     */
    public function banip(BanIpBindingModel $model)
    {
        $this->eshopData->getUsersRepository()->banIP($model->getIpAddress());

        RouteService::redirect('admin', 'ban', [], true);
    }
}