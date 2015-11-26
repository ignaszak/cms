<?php

defined('ACCESS') or die();

Display\DisplayExtension::addExtensionClass(array(
    'Display\\Extension\\User',
    'Form\\Form',
    'Pagination\\Pagination',
    'System\\Router\\Route',
    'Content\\Query\\Content'
));
