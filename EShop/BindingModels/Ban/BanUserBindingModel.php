<?php

namespace DF\BindingModels\Ban;

use DF\BindingModels\IBindingModel;

class BanUserBindingModel implements IBindingModel
{
    private $username;

    public function getUsername()
    {
        return $this->username;
    }
}