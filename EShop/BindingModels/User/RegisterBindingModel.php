<?php

namespace DF\BindingModels\User;

use DF\BindingModels\IBindingModel;

class RegisterBindingModel implements IBindingModel
{
    private $username;
    private $password;
    private $confirmPassword;
    private $email;
    protected $cash = null;

    public function __construct($bindingData) {
        if(isset($bindingData)) {
            $this->setUsername($bindingData['username']);
            $this->setPassword($bindingData['password']);
            $this->setConfirmPassword($bindingData['confirmPassword']);
            $this->setEmail($bindingData['email']);
        }
    }

    public function getConfirmPassword() {
        return $this->confirmPassword;
    }

    public function setConfirmPassword($confirmPassword) {
        $this->confirmPassword = $confirmPassword;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($value) {
        $this->username = $value;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($value) {
        $this->password = $value;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    public function getCash() {
        return $this->cash;
    }

    public function setCash($value) {
        $this->cash = $value;
    }
}