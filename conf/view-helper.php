<?php

defined('ACCESS') or die();

ViewHelper\ViewHelperExtension::addExtensionClass(array(
    'ViewHelper\\Extension\\User',
    'Form\\Form',
    'Pagination\\Pagination',
    'System\\Router\\Route',
    'Content\\Query\\Content',
    'Breadcrumbs\\Breadcrumbs'
));
