<?php

namespace System\Router;

use Ignaszak\Router\Client;

class Storage
{

    public static function getRoute($route = '')
    {
        return Client::getRoute($route);
    }

    public static function getAllRoutes()
    {
        return Client::getAllRoutes();
    }

    public static function isRouteName($name)
    {
        return Client::isRouteName($name);
    }

    public static function getControllerFile()
    {
        return Client::getControllerFile();
    }

    public static function getRouteName()
    {
        return Client::getRouteName();
    }

    public static function getDefaultRoute()
    {
        return Client::getDefaultRoute();
    }

}
