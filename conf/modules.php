<?php

defined('ACCESS') or die();

Display\DisplayExtension::addExtensionClass(array(
    'Display\\Extension\\User',
    'Form\\Form',
    'Display\\Extension\\Pagination',
    'System\\Router\\Route',
    'Content\\Query\\Content'
));

//echo "<pre>";
//print_r(System\Server::getReferData());
//echo "</pre>";
