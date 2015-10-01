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
}