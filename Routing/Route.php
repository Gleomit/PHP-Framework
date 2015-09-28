<?php

namespace DF\Routing;

class Route
{
    private $controller;
    private $action;
    private $method;
    private $pattern;

    public function __construct ($pattern, $controller, $action, $method) {
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->action = $action;

        $requestMethods = array_filter(array_flip((new \ReflectionClass('\DF\Library\Request'))->getConstants()), function($const) {
            return strpos($const, 'TYPE') === 0;
        });

        if(!in_array($method, array_keys($requestMethods))) {
            throw new \Exception('Invalid request method');
        }

        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getPattern()
    {
        return $this->pattern;
    }
}