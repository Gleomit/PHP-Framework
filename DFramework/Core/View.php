<?php

namespace DF\Core;

use DF\FrontController;

class View
{
    private $frontController;

    public function setFrontController(FrontController $frontController) {
        $this->frontController = $frontController;
    }

    public function getFrontController() {
        return $this->frontController;
    }
}