<?php

namespace DF\Controllers;

use DF\BindingModels\TestBindingModel;
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
     * @GET
     *
     * @Route("")
     */
    public function index (TestBindingModel $model) {
        echo FormViewHelper::init()
            ->initTextField()
            ->setAttribute('value', 'test')
            ->create()
            ->render();
    }

    /**
     * @Route("blqblq/{id:num}/{test:num}")
     * @POST
     */
    public function madafaka($id, $test) {

    }

    /**
     * @Route("{id:num}/profile/{test:num}")
     */
    public function testMe($id, $test) {
        echo 'profileeeeeeeeeeeeeeeeeee';
    }
}
