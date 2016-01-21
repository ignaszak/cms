<?php
namespace Test\Init;

use Ignaszak\Router\Start;
use Ignaszak\Router\Client;

class InitRouter
{

    private static $_router;

    public static function start(string $requestURI, string $defaultRoute = '')
    {
        $_SERVER['REQUEST_URI'] = $requestURI;
        $_SERVER['SERVER_NAME'] = '';
        self::$_router = new Start();
        self::$_router->baseURL = '';
        self::$_router->defaultRoute = $defaultRoute;
    }

    public static function defaultRoute(string $defaultRoute)
    {
        self::$_router = new Start();
        self::$_router->defaultRoute = $defaultRoute;
        self::$_router->run();
    }

    public static function add(string $name, string $pattern, string $controller = '')
    {
        self::$_router->add($name, $pattern, $controller);
    }

    public static function addToken(string $name, string $token)
    {
        self::$_router->addToken($name, $token);
    }

    public static function addController(string $name, array $options)
    {
        self::$_router->addController($name, $options);
    }

    public static function run()
    {
        self::$_router->run();
    }

    public static function getRouteName(): string
    {
        return Client::getRouteName();
    }

    public static function getAllRoutes(): array
    {
        return Client::getAllRoutes();
    }

    public static function getRoute(): string
    {
        return Client::getRoute();
    }
}
