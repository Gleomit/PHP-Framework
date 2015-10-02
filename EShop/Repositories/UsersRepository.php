<?php

namespace DF\Repositories;


use DF\BindingModels\User\RegisterBindingModel;
use DF\Config\AppConfig;
use DF\Config\DatabaseConfig;
use DF\Models\Cart;
use DF\Models\User;

class UsersRepository implements IRepository
{
    private $db;
    const TABLE_NAME = "users";

    public function __construct() {
        $this->db = \DF\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function create(RegisterBindingModel $user) {
        if($user->getPassword() != $user->getConfirmPassword()) {
            throw new InvalidUserInputException('Passwords does not match');
        }

        $isCreated = $this->db->insertEntity(self::TABLE_NAME, array(
            'username' => $user->getUsername(),
            'password' => password_hash($user->getPassword(), AppConfig::PASSWORD_HASH_ALGORITHM),
            'email' => $user->getEmail(),
            'cash' => $user->getCash(),
            'role_id' => $user->getRole()
        ));

        return $isCreated;
    }

    public function remove($id) {
    }

    public function findById($id) {
        $data = $this->db->getEntityById(self::TABLE_NAME, $id);

        if($data == null) {
            return null;
        }

        $user = new UserViewModel($data);
        return $user;
    }

    public function findByUsername($username) {
        $data = $this->db->getEntityByColumnName(self::TABLE_NAME, 'username', $username);

        if($data == null) {
            return null;
        }

        $user = new User($data);
        return $user;
    }

    public function getUserCart($userId) {
        $statement = $this->db->prepare("
            SELECT * FROM usercart AS uc WHERE uc.user_id = ?
        ");

        if(!$statement->execute([$userId])) {
            echo $statement->errorInfo();
            return false;
        }

        $userCart = new Cart($statement->fetch());
        return $userCart;
    }

    public function getUserProducts($id) {
        $data = $this->db->getUserProducts($id);

        $products = [];

        foreach ($data as $row) {
            $minifiedProduct = new MiniProduct($row);
            array_push($products, $minifiedProduct);
        }

        return $products;
    }
}