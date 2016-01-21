<?php
$router->add('admin', '(' . ADMIN_URL . ')/', 'admin-index');

new Admin\Extension\ExtensionLoader();

$adminBaseDir = dirname(__DIR__) . '/';
