<?php

defined('ACCESS') or die();

ViewHelper\ViewHelperExtension::addExtensionClass(array(
    'ViewHelper\\Extension\\User',
    'ViewHelper\\Extension\\Page',
    'ViewHelper\\Extension\\Post',
    'Form\\Form',
    'Pagination\\Pagination',
    'System\\Router\\Route',
    'Breadcrumbs\\Breadcrumbs',
    'Module\\Module',
    'Menu\\Menu'
));
