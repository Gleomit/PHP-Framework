<?php

namespace DF\Library\ViewHelpers\Elements;


class Checkbox extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "checkbox");

        return $this;
    }
}