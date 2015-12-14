<?php

defined('ACCESS') or die();

$router->defaultRoute = 'post';

$router->add('post', 'post/{page}');
$router->add('post', 'post/{alias}');
$router->add('post', 'post/{alias}/{page}');

$router->add('category', 'category/{page}');

$router->add('user', '(user)', 'user');
$router->add('user', '(user)/{method}/{userAction}', 'Controller\UserAuthenticationController');
$router->add('user', '(user)/(login)/{userName}');

$router->addToken('alias', '([a-z0-9_-]*)');
$router->addToken('page', '([0-9]*)');
$router->addToken('method', '(post|ajax)');

$router->addToken('userAction', '(registration|login|logout|remind)');
$router->addToken('userName', '([a-Z_-0-9]*)');

$router->run();

//echo "<pre>";
//print_r(System\Router\Storage::getAllRoutes());
//echo "</pre>";
