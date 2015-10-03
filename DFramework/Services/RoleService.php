<?php

namespace DF\Services;


use DF\Config\DatabaseConfig;
use DF\Core\Database;

class RoleService
{
    public static function userInRoles($userId, array $roles) {
        $userRoles = self::getUserRoles($userId);

        foreach($roles as $role) {
            if(in_array($role, $userRoles)) {
                return true;
            }
        }

        return false;
    }

    public static function getUserRoles($userId) {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE);

        $result = $db->prepare("
            SELECT r.name FROM user_roles AS ur
            INNER JOIN roles AS r ON r.id = ur.role_id
            WHERE ur.user_id = ?
        ");

        $result->execute([$userId]);

        $data = $result->fetchAll(\PDO::FETCH_COLUMN);

        return $data;
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