<?php

defined('ACCESS') or die();

session_save_path (__DIR__ . '/session');
session_start();
System\Server::readReferData();

$cms = new Display\DisplayFactory;

$user = UserAuth\User::instance();

require __DIR__ . '/conf/modules.php';

if (System\Router\Storage::isRouteName('admin')) {
    require __DIR__ . '/' . ADMIN_FOLDER . '/conf/modules.php';
}
