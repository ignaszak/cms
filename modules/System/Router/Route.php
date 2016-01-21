<?php
namespace System\Router;

use Ignaszak\Router\Client;

class Route
{

    public function __get($name)
    {
        $routeArray = Client::getAllRoutes();
        return array_key_exists($name, $routeArray) ? $routeArray[$name] : null;
    }

    /**
     * Return getRoute function from Router class
     *
     * @param array $rout
     * @return
     *
     */
    public function getRoute($route = null)
    {
        return Storage::getRoute($route);
    }

    /**
     *
     * @param string $name
     * @return string
     */
    public function getRouteName($name = null)
    {
        return Storage::getRouteName($name);
    }

    /**
     *
     * @return string
     */
    public function getRouteDefault()
    {
        return Storage::getDefaultRoute();
    }
}
