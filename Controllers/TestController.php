<?php

namespace DF\Controllers;

use DF\Library\BaseController;
use DF\Library\ViewHelpers\FormViewHelper;

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
