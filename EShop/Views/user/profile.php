<?php
echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
    ->setMethod('POST')
    ->setAction(\DF\Services\RouteService::$basePath . '/account/cart/checkout')
    ->initSubmitButton()
    ->setValue('checkout')
    ->create()
    ->render();
