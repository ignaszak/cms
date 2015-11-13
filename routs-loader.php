<?php

defined('ACCESS') or die();

$router = Ignaszak\Router\Start::instance();
$router->baseURL = $conf->getBaseUrl();

require __DIR__ . '/' . ADMIN_FOLDER . '/conf/router.php'; // Load admin router requests
require __DIR__ . '/conf/router.php';                // Load router requests