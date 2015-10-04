<?php

namespace DF\BindingModels\Ban;

use DF\BindingModels\IBindingModel;

class BanIpBindingModel implements IBindingModel
{
    private $ipAddress;

    public function getIpAddress() {
        return $this->ipAddress;
    }
}