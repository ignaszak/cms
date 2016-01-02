<?php

defined('ACCESS') or die();

ViewHelper\ViewHelperExtension::addExtensionClass(array(
    'ViewHelper\\Extension\\User',
    'ViewHelper\\Extension\\Page',
    'ViewHelper\\Extension\\Post',
    'Form\\Form',
    'Pagination\\Pagination',
    'System\\Router\\Route',
    'Content\\Query\\Content',
    'Breadcrumbs\\Breadcrumbs',
    'Module\\Module'
));
