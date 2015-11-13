<?php

defined('ACCESS') or die();

$router->add('admin', '(' . ADMIN_URL . ')/', 'admin-index');

new Admin\Extension\ExtensionLoader; // Load routs from extension configuration file

#$router->addToken('alias', '([a-z_-]*)([0-9]*)');

$adminBaseDir = dirname(__DIR__) . '/';
$router->addController('admin-index', array(
    'file' => $adminBaseDir . 'extensions/index/index.php'
));
