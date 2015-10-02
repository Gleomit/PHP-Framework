<?php

namespace DF\BindingModels\User;

use DF\BindingModels\IBindingModel;

class LoginBindingModel implements IBindingModel
{
    private $_username;
    private $_password;

    public function __construct($bindingData) {
        $this->setUsername($bindingData['username']);
        $this->setPassword($bindingData['password']);
    }

    public function getUsername() {
        return $this->_username;
    }

    public function setUsername($value) {
        $this->_username = $value;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($value) {
        $this->_password = $value;
    }
}