<?php

defined('ACCESS') or die();

$baseDir = dirname(dirname(__DIR__));

if (!$user->isUserLoggedIn()) {
    require $baseDir . '/' . ADMIN_FOLDER . '/extensions/index/login.html';
    exit;
}

if ($cms->getUserRole() != 'admin') {
    System\System::headerLocation('');
}

Display\DisplayExtension::addExtensionClass(array(
    'Admin\\Extension\\Display\\Admin'
));
