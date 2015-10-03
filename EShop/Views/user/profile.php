<?php
echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
    ->setMethod('POST')
    ->setAction(\DF\Services\RouteService::getUrl('products', '1'))
    ->initTextField()
    ->setName('categoryId')
    ->create()
    ->initSubmitButton()
    ->setValue('change category')
    ->create()
    ->render();
