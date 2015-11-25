<?php

define('FORM_ACTION', System\Router\Storage::getRoute('formAction')) ;

if (FORM_ACTION == 'new') {
    \System\Server::setReferData(array('incorrectLoginData'=>1));
    \System\Server::headerLocationReferer();
}

if (FORM_ACTION) System\Server::headerLocationReferer();
