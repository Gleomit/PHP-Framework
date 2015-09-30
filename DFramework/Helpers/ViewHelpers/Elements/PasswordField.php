<?php

namespace DF\Helpers\ViewHelpers\Elements;


class PasswordField extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "password");

        return $this;
    }
}