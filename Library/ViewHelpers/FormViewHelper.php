<?php

namespace DF\Library\ViewHelpers;

use DF\Library\ViewHelpers\Elements\Checkbox;
use DF\Library\ViewHelpers\Elements\PasswordField;
use DF\Library\ViewHelpers\Elements\RadioButton;
use DF\Library\ViewHelpers\Elements\TextArea;
use DF\Library\ViewHelpers\Elements\TextField;

class FormViewHelper
{
    /**
     * @var Elements\Element[]
     */
    public static $elements = [];
    private static $attributes = [];
    private static $classes = [];

    public static function init($ajaxForm = false) {
        self::$elements = [];
        self::$attributes = [];

        self::setAttribute("class", "ajaxForm");

        return new self();
    }

    public static function render() {
        self::setAttribute('class', implode(' ', self::$classes));

        $attributesString = "";

        foreach(self::$attributes as $attribute => $value) {
            $attributesString .= " $attribute = " . "\"$value\"";
        }

        $result = "<form" . $attributesString . ">";

        foreach(self::$elements as $element) {
            $result .= "<$element->elementName";

            $attributesString = "";

            foreach($element->attributes as $attribute => $value) {
                if($attribute != 'value' && $element->innerValue === false) {
                    $attributesString .= " $attribute = " . "\"$value\"";
                }
            }

            $result .= $attributesString . ">";

            if($element->innerValue === true) {
                $result .= ($element->attributes['value'] != null ? $element->attributes['value'] : "");
                $result .= "</$element->elementName>";
            }
        }

        $result .= "</form>";

        return $result;
    }

    public static function setAction($action) {
        self::setAttribute("action", $action);
        return new self();
    }

    public static function setMethod($method) {
        self::setAttribute("method", $method);
        return new self();
    }

    public static function setAttribute($attribute, $value) {
        if(strtolower($attribute) == "class") {
            if(is_array($value)) {
                self::$classes = array_merge(self::$classes, $value);
            } else {
                self::$classes[] = $value;
            }
        } else {
            self::$attributes[$attribute] = $value;
        }

        return new self();
    }

    public static function setAttributes(array $attributes, array $values) {
        if(count($attributes) != count($values)) {
            throw new \Exception("Difference between attributes and values elements length");
        }

        for($i = 0; $i < count($attributes); $i++) {
            if($attributes[$i] == 'class') {
                if(is_array($values[$i])) {
                    self::$classes = array_merge(self::$classes, $values[$i]);
                } else {
                    self::$classes[] = $values[$i];
                }
            } else {
                self::$attributes[$attributes[$i]] = $values[$i];
            }
        }

        return new self();
    }

    public static function initTextField() {
        return new TextField();
    }

    public static function initTextArea() {
        return new TextArea();
    }

    public static function initPasswordField() {
        return new PasswordField();
    }

    public static function initRadioButton() {
        return new RadioButton();
    }

    public static function initCheckbox() {
        return new Checkbox();
    }
}
