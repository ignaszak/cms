<?php

defined('ACCESS') or die();

$baseDir = dirname(__DIR__) . '/includes/';

$router->defaultRoute = 'post';

/*
 * Set first site (default post)
 */
// $router->setDefaultRoute('category');

/*
 * Add routs to defined names.
 * $router->add(string name, string pattern [, string controller]);
 * Names are used to check if 
 * defined rout is avilable:
 *      if ($router->routName('home') { // Do something
 * Or:
 *      if ($router->routName() == 'home') { // Do something
 */
$router->add('post', 'post/{page}');              // Post list, page
$router->add('post', 'post/{alias}');             // Display post based on alias
$router->add('post', 'post/{alias}/{page}');             // Display post based on alias
$router->add('category', 'category/{page}');      // Category list, page
$router->add('category', 'category/{alias}');     // Display category based on alias

/*
 * Add tokens
 */
$router->addToken('alias', '([a-z0-9_-]*)');
$router->addToken('page', '([0-9]*)');
$router->addToken('method', '(post|ajax)');

/*
 * Add controllers
 */
// $router->addController('controllerName', array(
//     'file' => 'filename'
// ));

/*
 * User routs
 *      user - display registration and remind form
 *      user/(post|ajax)/(registration|login|logout|remind) - send post/ajax to user script
 *      user/login/([a-Z_-0-9]*) - display user site
 */
$router->add('user', '(user)', 'user');
$router->add('user', '(user)/{method}/{userAction}', 'user');
$router->add('user', '(user)/(login)/{userName}');
$router->addToken('userAction', '(registration|login|logout|remind)');
$router->addToken('userName', '([a-Z_-0-9]*)');
$router->addController('user', array(
    'file' => $baseDir . 'user.php'
));

/*
 * Get rout 
 */
$router->run();

echo "<pre>";
print_r(System\Router\Storage::getAllRoutes());
echo "</pre>";
