<?php

namespace DF\BindingModels\Category;

use DF\BindingModels\IBindingModel;

class CreateCategoryBindingModel implements IBindingModel
{
    private $name;

    public function __construct($data)
    {
        if(isset($data)) {
            $this->setName($data['name']);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}