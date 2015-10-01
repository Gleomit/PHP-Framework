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
     * @GET
     * @Authorize
     * @Route("")
     */
    public function index () {
        echo FormViewHelper::init()
            ->initTextField()
            ->setAttribute('value', 'test')
            ->create()
            ->render();
    }

    /**
     * @Route("blqblq/{id:num}")
     * @POST
     */
    public function madafaka($id) {

    }

    /**
     * @Route("{id:num}/profile/{id:num}")
     */
    public function testMe() {
        echo 'profileeeeeeeeeeeeeeeeeee';
    }
}
