<?php

namespace DF\Models;

class User extends BaseModel
{
    private $_id;
    private $_username;
    private $_password;
    private $_email;
    private $_fullName;
    private $_age;
    private $_roleId = null;
    private $_cash = null;

    public function __construct($data) {
        $this->setId($data['id']);
        $this->setUsername($data['username']);
        $this->setPassword($data['password']);
        $this->setEmail($data['email']);
        $this->setFullName($data['full_name']);
        $this->setRole($data['role_id']);
        $this->setAge($data['age']);
        $this->setCash($data['cash']);
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getFullName() {
        return $this->_fullName;
    }

    public function setFullName($fullName) {
        $this->_fullName = $fullName;
    }

    public function getAge() {
        return $this->_age;
    }

    public function setAge($age) {
        $this->_age = $age;
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

    public function getRole() {
        return $this->_roleId;
    }

    public function setRole($value) {
        $this->_roleId = $value;
    }

    public function getCash() {
        return $this->_cash;
    }

    public function setCash($value) {
        $this->_cash = $value;
    }
}