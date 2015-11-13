<?php

namespace Display\Extension;

class Route
{

    /**
     * Return getRoute function from Router class
     *
     * @param array $rout
     * @return
     */
    public function getRoute($route = null)
    {
        return \Ignaszak\Router\Client::getRoute($route);
    }

    /**
     *
     * @param string $name
     */
    public function getRouteName($name = null)
    {
        return \Ignaszak\Router\Client::getRouteName($name);
    }

    public function getRouteDefault()
    {
        return \Ignaszak\Router\Client::getDefaultRoute();
    }
}
