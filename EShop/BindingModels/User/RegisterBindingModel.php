<?php

namespace DF\BindingModels\User;

use DF\BindingModels\IBindingModel;

class RegisterBindingModel implements IBindingModel
{
    private $_username;
    private $_password;
    private $_confirmPassword;
    private $_email;
    protected $_role = null;
    protected $_cash = null;

    public function __construct($bindingData) {
        $this->setUsername($bindingData['username']);
        $this->setPassword($bindingData['password']);
        $this->setConfirmPassword($bindingData['confirmPassword']);
        $this->setEmail($bindingData['email']);
        $this->setRole($bindingData['role']);
    }

    public function getRole() {
        return $this->_role;
    }

    public function setRole($role) {
        $this->_role = $role;
    }

    public function getConfirmPassword() {
        return $this->_confirmPassword;
    }

    public function setConfirmPassword($confirmPassword) {
        $this->_confirmPassword = $confirmPassword;
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

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail($value) {
        $this->_email = $value;
    }

    public function getCash() {
        return $this->_cash;
    }

    public function setCash($value) {
        $this->_cash = $value;
    }
}