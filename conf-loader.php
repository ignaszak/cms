<?php

use Ignaszak\Registry\RegistryFactory;
use Ignaszak\Registry\Conf as RegistryConf;
use Ignaszak\Router\Start as Router;
use UserAuth\User;

defined('ACCESS') or die();

// Run installer if DBSettings.php not exists
if (!file_exists(__DIR__ . '/conf/DB/DBSettings.php')) {
    header('Location: ./install');
}

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

// LOAD VIEW PATTERN
RegistryFactory::start()->set('view', new View\View);
$view = RegistryFactory::start()->get('view');

// CHECK PERMISSIONS TO ADMIN PANEL AND LOAD ADMIN VIEW HELPER EXTENSIONS
// User classes
RegistryFactory::start()->set('user', new User);
$user = RegistryFactory::start()->get('user');
// Default view helper classes
require __DIR__ . '/conf/view-helper.php';
// Check admin panel route
if (System\Router\Storage::isRouteName('admin')) {
    // If not logged open login panel
    if (!$user->isUserLoggedIn()) {
        $view->loadFile('../../extensions/Index/login.html');
        exit;
    }
    // Check permissions
    if ($user->getUserSession()->getRole() != 'admin') {
        System\Server::headerLocation(''); // Go to main page
    }
    // Admin view helper classes
    require __DIR__ . '/' . ADMIN_FOLDER . '/conf/view-helper.php';
}

// LOAD FRONT CONTROLLER
FrontController\FrontController::run();

// LOAD INDEX.HTML FROM THEME
$view->loadFile('index.html');