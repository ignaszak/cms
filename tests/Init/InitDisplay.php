<?php

namespace Test\Init;

use Display\DisplayExtension;

class InitDisplay
{

    public static function loadExtensions()
    {
        DisplayExtension::addExtensionClass(array(
            'Display\\Extension\\User',
            'Form\\Form',
            'Pagination\\Pagination',
            'System\\Router\\Route',
            'Content\\Query\\Content'
        ));
    }

}
