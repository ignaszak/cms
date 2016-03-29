<?php

/**
 *
 * POST
 *
 */
$route->group('post');
$controller = 'Controller\ViewPostController';
$route->get('post-default',  '/{page}')             ->controller($controller);
$route->get('post-list',     '/post/{page}')        ->controller($controller);
$route->get('post-alias',    '/post/{alias}')       ->controller($controller);
$route->get('post-com-list', '/post/{alias}/{page}')->controller($controller);

/**
 *
 * CATEGORY
 *
 */
$route->group('category');
$route->get('cat-list',       '/category/{page}')        ->controller($controller);
$route->get('cat-alias',      '/category/{alias}')       ->controller($controller);
$route->get('cat-alias-page', '/category/{alias}/{page}')->controller($controller);

/**
 *
 * DATE
 *
 */
$route->group('date');
$route->get('date', '/date/{date}')->controller($controller);
$route->get('dated', '/dated/{year}(-{month})?(-{day})?')->controller($controller);

/**
 *
 * PAGE
 *
 */
$route->group('page');
$route->get('page-alias', '/page/{alias}')->controller('Controller\ViewPageController');

/**
 *
 * USER
 *
 */
$route->group('user');
$route->get('user-account', '/user')->controller('Controller\User\UserViewController');

$route->post('user-login', '/user/{method}/{action}')->token('action', '(login)')
    ->controller('Controller\User\UserLoginController');

$route->add('user-logout', '/user/{method}/{action}')->token('action', '(logout)')
    ->controller('Controller\User\UserLogoutController');

$route->post('user-registration', '/user/{method}/{action}')->token('action', '(registration)')
    ->controller('Controller\User\UserRegistrationController');

$route->post('user-remind', '/user/{method}/{action}')->token('action', '(remind)')
    ->controller('Controller\User\UserRemindController');

$route->post('user-save', '/user/{method}/{action}')->token('action', '(account)')
    ->controller('Controller\User\UserSaveController');

/**
 *
 * SEARCH
 *
 */
$route->group('search');
$route->get('search', '/search/{page}')->controller('Controller\SearchController');

/**
 *
 * MAIL
 *
 */
$route->group('mail');
$route->get('mail', '/mail/send')->controller('Controller\SendMailController');

/**
 *
 * GLOBAL TOKENS
 *
 */
$router->addTokens([
    'id'       => '@digit',
    'alias'    => '@alnum',
    'page'     => '@digit',
    'date'     => '([0-9-]+)',
    'method'   => '(post|ajax)',
    'userName' => '@alnum',
    'year'     => '(\d{4})',
    'month'    => '(\d{2})',
    'day'      => '(\d{2})'
]);
