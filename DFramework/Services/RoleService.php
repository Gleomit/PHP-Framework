<?php

namespace DF\Services;


use DF\Config\DatabaseConfig;
use DF\Core\Database;

class RoleService
{
    public static function userInRoles($userId, array $roles) {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE);

        //check if roles are valid

        $validRoles = self::getRoles();

        foreach($roles as $role) {
            if(!in_array($role, $validRoles)) {
                throw new \Exception("Invalid Role used");
            }
        }

        $result = $db->prepare("
            SELECT * FROM user_roles AS ur ON ur.user_id = ?
            INNER JOIN roles AS r ON r.id = ur.role_id
            WHERE r.name IN (?)
        ");

        $result->execute([$userId, implode(", ", $roles)]);

        if($result->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public static function getRoles() {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE);

        $result = $db->prepare("
            SELECT * FROM roles
        ");

        $result->execute();

        $roles = [];

        if($result->rowCount() > 0) {
            $roles = $result->fetchAll(\PDO::FETCH_KEY_PAIR);
        }

        return array_flip($roles);
    }
}