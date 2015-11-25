<?php

namespace System\Router;

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
        return \System\Router\Storage::getRoute($route);
    }

    /**
     *
     * @param string $name
     */
    public function getRouteName($name = null)
    {
        return \System\Router\Storage::getRouteName($name);
    }

    public function getRouteDefault()
    {
        return \System\Router\Storage::getDefaultRoute();
    }

}
