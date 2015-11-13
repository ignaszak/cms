<?php

defined('ACCESS') or die();

session_start();
System\System::readReferData();

$cms = new Display\DisplayFactory;

$user = UserAuth\User::instance();

require __DIR__ . '/conf/modules.php';

if (Ignaszak\Router\Client::isRouteName('admin')) {
    require __DIR__ . '/' . ADMIN_FOLDER . '/conf/modules.php';
}
