<?php
namespace App\Resource;

use Ignaszak\Router\Client;

class RouterStatic
{

    /**
     *
     * @param string $route
     * @return string
     */
    public static function getRoute(string $route = ''): string
    {
        return Client::getRoute($route) ?? '';
    }

    /**
     * @return array
     */
    public static function getAllRoutes(): array
    {
        return Client::getAllRoutes() ?? [];
    }

    /**
     *
     * @param string $name
     * @return boolean
     */
    public static function isRouteName(string $name): bool
    {
        return Client::isRouteName($name);
    }

    /**
     * @return string
     */
    public static function getRouteName(): string
    {
        return Client::getRouteName() ?? '';
    }

    /**
     * @return string
     */
    public static function getDefaultRoute(): string
    {
        return Client::getDefaultRoute() ?? '';
    }
}
