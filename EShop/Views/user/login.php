<?php
    echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
        ->initTextField()
        ->setName('username')
        ->create()
        ->initPasswordField()
        ->setName('password')
        ->create()
        ->initSubmitButton()
        ->setValue('Login')
        ->create()
        ->setAction(\DF\Services\RouteService::getUrl('account', 'login'))
        ->setMethod('POST')
        ->render();
