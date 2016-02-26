<?php
namespace App\Resource;

use Ignaszak\Router\Client;

class Route
{

    /**
     *
     * @param string $name
     * @return string
     */
    public function __get(string $name): string
    {
        $routeArray = Client::getAllRoutes();
        return $routeArray[$name] ?? '';
    }

    /**
     * Return getRoute function from Router class
     *
     * @param string $route
     * @return string
     */
    public function getRoute(string $route = ''): string
    {
        return Client::getRoute($route) ?? '';
    }

    /**
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return Client::getRouteName() ?? '';
    }

    /**
     *
     * @return string
     */
    public function getDefaultRoute(): string
    {
        return Client::getDefaultRoute() ?? '';
    }
}
