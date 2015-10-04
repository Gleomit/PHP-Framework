<?php

namespace DF\BindingModels\Comment;

use DF\BindingModels\IBindingModel;

class CreateCommentBindingModel implements IBindingModel
{
    private $commentText;

    public function __construct($bindingModel) {
        if(isset($bindingModel)) {

        }
    }

    public function getCommentText()
    {
        return $this->commentText;
    }

    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;
    }
}