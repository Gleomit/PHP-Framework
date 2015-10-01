<?php

namespace DF\Helpers\ViewHelpers\Elements;


class SubmitButton extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "submit");

        return $this;
    }
}