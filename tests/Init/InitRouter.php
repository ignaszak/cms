<?php

namespace Test\Init;

use Ignaszak\Router\Start;

class InitRouter
{

    private static $_router;

    public static function start($requestURI, $defaultRoute = '')
    {
        $_SERVER['REQUEST_URI'] = $requestURI;
        $_SERVER['SERVER_NAME'] = '';
        self::$_router = Start::instance();
        self::$_router->baseURL = '';
        self::$_router->defaultRoute = $defaultRoute;
    }

    public static function add($name, $pattern, $controller = '')
    {
        self::$_router->add($name, $pattern, $controller);
    }

    public static function addToken($name, $token)
    {
        self::$_router->addToken($name, $token);
    }

    public static function addController($name, array $options)
    {
        self::$_router->addController($name, $options);
    }

    public static function run()
    {
        self::$_router->run();
    }

}
