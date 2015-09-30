<?php

namespace DF\Controllers;

use DF\Controllers\BaseController;
use DF\Helpers\ViewHelpers\FormViewHelper;

class TestController extends BaseController
{
    public function index () {
        echo FormViewHelper::init()
            ->initTextField()
            ->setAttribute('value', 'test')
            ->create()
            ->render();
    }
}
