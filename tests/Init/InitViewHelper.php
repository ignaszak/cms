<?php

namespace Test\Init;

use ViewHelper\ViewHelperExtension;

class InitViewHelper
{

    public static function loadExtensions()
    {
        ViewHelperExtension::addExtensionClass(array(
            'Display\\Extension\\User',
            'Form\\Form',
            'Pagination\\Pagination',
            'System\\Router\\Route',
            'Content\\Query\\Content'
        ));
    }

}
