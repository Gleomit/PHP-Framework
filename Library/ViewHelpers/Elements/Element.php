<?php

namespace DF\Library\ViewHelpers\Elements;

use DF\Library\ViewHelpers\FormViewHelper;

abstract class Element
{
    public $attributes = [];
    private $classes = [];
    public $elementName;
    public $innerValue = false;

    public function setName($value) {
        $this->attributes['name'] = $value;

        return $this;
    }

    public function setAttribute($attribute, $value) {
        if(strtolower($attribute) == "class") {
            $this->classes[] = $value;
        } else {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }

    public function setValue($value) {
        $this->setAttribute("value", $value);

        return $this;
    }

    public function create(){
        $this->setAttribute('class', implode(',', $this->classes));

        FormViewHelper::$elements[] = $this;

        return new FormViewHelper();
    }
}