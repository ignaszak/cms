<?php
namespace App\Resource;

use Ignaszak\Router\ResponseStatic;

class Route
{

    /**
     *
     * @param string $name
     * @return string
     */
    public function __get(string $name): string
    {
        $response = ResponseStatic::getParams();
        return $response[$name] ?? '';
    }

    /**
     * Return getRoute function from Router class
     *
     * @param string $token
     * @return string
     */
    public function getParam(string $token = ''): string
    {
        return ResponseStatic::getParam($token);
    }

    /**
     *
     * @return string
     */
    public function getName(): string
    {
        return ResponseStatic::getName();
    }

    /**
     *
     * @return string
     */
    public function getGroup(): string
    {
        return ResponseStatic::getGroup();
    }

    /**
     *
     * @return string
     */
    public function getController(): string
    {
        return ResponseStatic::getController();
    }

    /**
     *
     * @param string $name
     * @param array $replacement
     * @return string
     */
    public function getLink(string $name, array $replacement): string
    {
        return ResponseStatic::getLink($name, $replacement);
    }
}
