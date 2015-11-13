<?php

defined('ACCESS') or die();

Display\DisplayExtension::addExtensionClass(array(
    'Display\\Extension\\User',
    'Display\\Extension\\Form\\Form',
    'Display\\Extension\\Pagination',
    'Display\\Extension\\Route',
    'Display\\Extension\\Content\\Content'
));

//echo "<pre>";
//print_r(System\System::getReferData());
//echo "</pre>";
