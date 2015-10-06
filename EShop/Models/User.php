<?php

namespace DF\Models;

class User extends BaseModel
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $roles = [];
    private $cash = null;
    private $isBanned;

    public function __construct($data)
    {
        $this->setId($data['id']);
        $this->setUsername($data['username']);
        $this->setPassword($data['password_hash']);
        $this->setEmail($data['email']);
        $this->setRoles($data['roles']);
        $this->setCash($data['cash']);
        $this->setIsBanned($data['is_banned']);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($value)
    {
        $this->username = $value;
    }

    public function getIsBanned()
    {
        return $this->isBanned;
    }

    public function setIsBanned($value)
    {
        $this->isBanned = $value;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($value)
    {
        $this->password = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($value)
    {
        $this->roles = $value;
    }

    public function getCash()
    {
        return $this->cash;
    }

    public function setCash($value)
    {
        $this->cash = $value;
    }
}