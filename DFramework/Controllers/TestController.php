<?php

namespace DF\Controllers;

use DF\Controllers\BaseController;
use DF\Helpers\ViewHelpers\FormViewHelper;

/**
 *
 * Class TestController
 * @package DF\Controllers
 */
class TestController extends BaseController
{
    /**
     * @Route("test/")
     * @PUT
     * @Authorize
     */
    public function index () {
        echo FormViewHelper::init()
            ->initTextField()
            ->setAttribute('value', 'test')
            ->create()
            ->render();
    }
}
