<?php

namespace DF\Helpers\ViewHelpers\Elements;

use DF\Helpers\ViewHelpers\FormViewHelper;

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
        if($attribute === "class") {
            if(is_array($value)) {
                $this->classes = array_merge($this->classes, $value);
            } else {
                $this->classes[] = $value;
            }
        } else {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }

    public function setAttributes(array $attributes, array $values) {
        if(count($attributes) != count($values)) {
            throw new \Exception("Difference between attributes and values elements length");
        }

        for($i = 0; $i < count($attributes); $i++) {
            if($attributes[$i] == 'class') {
                if(is_array($values[$i])) {
                    $this->classes = array_merge($this->classes, $values[$i]);
                } else {
                    $this->classes[] = $values[$i];
                }
            } else {
                $this->attributes[$attributes[$i]] = $values[$i];
            }
        }

        return $this;
    }

    public function setValue($value) {
        $this->setAttribute("value", $value);

        return $this;
    }

    public function create(){
        $this->attributes["class"] = implode(' ', $this->classes);

        FormViewHelper::$elements[] = $this;

        return new FormViewHelper();
    }
}