<?php

namespace DF\Config;


class AppConfig
{
    const FRAMEWORK_NAMESPACE = 'DF';
    const FRAMEWORK_CONTROLLERS_NAMESPACE = self::FRAMEWORK_NAMESPACE . '\\' . 'Controllers';

    const APP_NAMESPACE = 'EShop';
    const APP_CONTROLLERS_NAMESPACE = self::APP_NAMESPACE . '\\' . 'Controllers';

    const CONTROLLER_SUFFIX = 'Controller';
    const DEFAULT_CONTROLLER = 'home';
    const DEFAULT_CONTROLLER_ACTION = 'index';

    const PASSWORD_HASH_ALGORITHM = PASSWORD_DEFAULT;

    const DEFAULT_USER_ROLE = 'User';
    const ADMIN_USER_ROLE = 'Administrator';
    const EDITOR_USER_ROLE = 'Editor';

    public static $PROMOTION_TYPES = array(
        'All Products' => '1',
        'Certain Products' => '2',
        'Certain Categories' => '3',
        'User criteria' => '4');
}