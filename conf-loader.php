<?php

use Ignaszak\Registry\RegistryFactory;
use Ignaszak\Registry\Conf as RegistryConf;
use Ignaszak\Router\Start as Router;
use ViewHelper\ViewHelper;
use UserAuth\User;

defined('ACCESS') or die();

// Configure exception handler
require __DIR__ . '/conf/exception-handler.php';

// Configure and start session
session_save_path (__DIR__ . '/cache/session');
session_start();

// Define registry tmp path
RegistryConf::setTmpPath(__DIR__ . '/cache/registry');

// This method loads refer data from session
// and pass their into System\Server::getReferData().
// This method is used e.g. to show message about 
// invalid login or password
System\Server::readReferData();

// ROUTER
// Configure router
$router = Router::instance();
$router->baseURL = RegistryFactory::start('file')->register('Conf\Conf')->getBaseUrl();
$router->defaultRoute = 'post';
// Adds router patterns
require __DIR__ . '/' . ADMIN_FOLDER . '/conf/router.php';
require __DIR__ . '/conf/router.php';
// Initialize router
$router->run();

// CHECK PERMISSIONS TO ADMIN PANEL AND LOAD ADMIN VIEW HELPER EXTENSION
// Register ViewHelper and User classes
RegistryFactory::start()->set('cms', new ViewHelper);
$cms = RegistryFactory::start()->get('cms');
RegistryFactory::start()->set('user', new User);
$user = RegistryFactory::start()->get('user');
// Default view helper classes
require __DIR__ . '/conf/view-helper.php';
// Check admin panel route
if (System\Router\Storage::isRouteName('admin')) {
    // If not logged open login panel
    if (!$user->isUserLoggedIn()) {
        require __DIR__ . '/' . ADMIN_FOLDER . '/extensions/Index/login.html';
        exit;
    }
    // Check permissions
    if ($cms->getUserRole() != 'admin') {
        System\Server::headerLocation(''); // Go to main page
    }
    // Admin view helper classes
    require __DIR__ . '/' . ADMIN_FOLDER . '/conf/view-helper.php';
}
