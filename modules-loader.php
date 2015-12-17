<?php

use Ignaszak\Registry\RegistryFactory;

defined('ACCESS') or die();

session_save_path (__DIR__ . '/cache/session');
session_start();
System\Server::readReferData();

RegistryFactory::start()->set('cms', new ViewHelper\ViewHelper);
RegistryFactory::start()->set('user', new UserAuth\User);

require __DIR__ . '/conf/modules.php';

if (System\Router\Storage::isRouteName('admin')) {
    require __DIR__ . '/' . ADMIN_FOLDER . '/conf/modules.php';
}
