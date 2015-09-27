<?php

namespace DF\Routing;

class Route
{
    private $_controller;
    private $_action;
    private $_method;
    private $_params;

    public function __construct ($controller, $action, $method, $params) {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_method = $method;
        $this->_params = $params;
    }


}