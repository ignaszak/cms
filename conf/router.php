<?php
$router->add('post', 'post/{page}', 'Controller\ViewPostController');
$router->add('post', 'post/{alias}', 'Controller\ViewPostController');
$router->add('post', 'post/{alias}/{page}', 'Controller\ViewPostController');

$router->add('category', 'category/{page}', 'Controller\ViewPostController');
$router->add('category', 'category/{alias}', 'Controller\ViewPostController');

$router->add('date', 'date/{date}', 'Controller\ViewPostController');

$router->add('page', 'page/{alias}', 'Controller\ViewPageController');

$router->add('user', 'user', 'Controller\User\UserViewController');
$router->add('user', 'user/login/{userName}', 'Controller\User\UserViewController');
$router->add('user', 'user/{method}/{action:login}', 'Controller\User\UserLoginController');
$router->add('user', 'user/{method}/{action:logout}', 'Controller\User\UserLogoutController');
$router->add('user', 'user/{method}/{action:registration}', 'Controller\User\UserRegistrationController');

$router->add('search', 'search/{page}', 'Controller\SearchController');

$router->add('mail', 'mail/send', 'Controller\SendMailController');

$router->addToken('id', '([0-9]*)');
$router->addToken('alias', '([a-z0-9_-]*)');
$router->addToken('page', '([0-9]*)');
$router->addToken('date', '([0-9-]*)');
$router->addToken('method', '(post|ajax)');
$router->addToken('userName', '([a-Z_-0-9]*)');
