<?php

define('FORM_ACTION', Ignaszak\Router\Client::getRoute('formAction')) ;

if (FORM_ACTION == 'new') {
    \System\System::setReferData(array('incorrectLoginData'=>1));
    \System\System::headerLocationReferer();
}

if (FORM_ACTION) System\System::headerLocationReferer();
