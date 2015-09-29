<?php

namespace DF\Library;

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