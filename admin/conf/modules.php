<?php

use Ignaszak\Registry\RegistryFactory;
use ViewHelper\ViewHelperExtension;

defined('ACCESS') or die();

$baseDir = dirname(dirname(__DIR__));
$user = RegistryFactory::start()->get('user');
$cms = RegistryFactory::start()->get('cms');

if (!$user->isUserLoggedIn()) {
    require $baseDir . '/' . ADMIN_FOLDER . '/extensions/Index/login.html';
    exit;
}

if ($cms->getUserRole() != 'admin') {
    System\Server::headerLocation('');
}

ViewHelperExtension::addExtensionClass(array(
    'Admin\\Extension\\ViewHelper\\Admin'
));
