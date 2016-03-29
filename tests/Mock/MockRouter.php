<?php
namespace Test\Mock;

use Ignaszak\Router\Router;
use Ignaszak\Router\Route;
use Ignaszak\Router\Interfaces\IRouteAdd;

class MockRouter
{

    /**
     *
     * @var \Ignaszak\Router\Route
     */
    private static $_route;

    /**
     *
     * @var \Ignaszak\Router\Router
     */
    private static $_router;

    /**
     *
     * @var \Ignaszak\Router\Response
     */
    private static $response;

    /**
     *
     * @var string
     */
    private static $requestURI;

    /**
     *
     * @param string $requestURI
     * @param string $defaultRoute
     */
    public static function start(string $requestURI, string $defaultRoute = '')
    {
        self::$requestURI = $requestURI;
        self::$_route = Route::start();
        self::$_route->add($defaultRoute, '@base');
        self::$_router = new Router(self::$_route);
    }

    /**
     *
     * @param string $defaultRoute
     */
    public static function defaultRoute(string $defaultRoute)
    {
        self::$_route = Route::start();
        self::$_route->add($defaultRoute, '@base');
        self::$_router = new Router(self::$_route);
        self::$_router->run(null, '/');
    }

    /**
     *
     * @param string $name
     * @param string $pattern
     */
    public static function add(
        string $name,
        string $pattern,
        string $method = ''
    ): IRouteAdd {
        return self::$_route->add($name, $pattern, $method);
    }

    /**
     *
     * @param string $name
     */
    public static function group(string $name = '')
    {
        self::$_route->group($name);
    }

    /**
     *
     * @param string $name
     * @param string $token
     */
    public static function addToken(string $name, string $token)
    {
        self::$_router->addToken($name, $token);
    }

    public static function run()
    {
        self::$response = self::$_router->run(null, self::$requestURI);
    }

    public static function getName(): string
    {
        return self::$response->getName();
    }

    public static function getParams(): array
    {
        return self::$response->getParams();
    }

    /**
     *
     * @param string $token
     */
    public static function getParam(string $token): string
    {
        return self::$response->getParam($token);
    }
}
