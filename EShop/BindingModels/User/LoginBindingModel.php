<?php

namespace DF\BindingModels\User;

use DF\BindingModels\IBindingModel;

class LoginBindingModel implements IBindingModel
{
    private $username;
    private $password;

    public function __construct($bindingData)
    {
        if(isset($bindingData)) {
            $this->setUsername($bindingData['username']);
            $this->setPassword($bindingData['password']);
        }
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($value)
    {
        $this->username = $value;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($value)
    {
        $this->password = $value;
    }
}