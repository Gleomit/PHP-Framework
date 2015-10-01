<?php

namespace DF\Controllers;

use DF\BindingModels\TestBindingModel;
use DF\Helpers\ViewHelpers\FormViewHelper;
use DF\Services\RouteService;

/**
 *
 * Class TestController
 * @package DF\Controllers
 */
class TestController extends BaseController
{
    /**
     * @POST
     *
     * @Route("")
     */
    public function index (TestBindingModel $model) {
        echo $model->property;
    }

    /**
     * @Route("blqblq/{id:num}/{test:num}")
     *
     */
    public function madafaka($id, $test) {
        echo $id . '/' . $test;
    }

    /**
     *
     * @Route("test")
     */
    public function testMe() {
        echo FormViewHelper::init()
            ->initTextField()
            ->setAttribute('value', 'test')
            ->setName('property')
            ->create()
            ->setMethod("POST")
            ->setAction(RouteService::getUrl('test', ''))
            ->initSubmitButton()
            ->create()
            ->render();
    }
}
