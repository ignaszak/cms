<?php
namespace App\Resource;

use Ignaszak\Router\ResponseStatic;

class RouterStatic
{

    /**
     *
     * @param string $token
     * @return string
     */
    public static function getParam(string $token = ''): string
    {
        return ResponseStatic::getParam($token);
    }

    /**
     * @return array
     */
    public static function getParams(): array
    {
        return ResponseStatic::getParams();
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return ResponseStatic::getName();
    }

    /**
     *
     * @return string
     */
    public static function getGroup(): string
    {
        return ResponseStatic::getGroup();
    }

    /**
     *
     * @return string
     */
    public static function getController(): string
    {
        return ResponseStatic::getController();
    }

    /**
     *
     * @param string $name
     * @param array $replacement
     * @return string
     */
    public static function getLink(string $name, array $replacement): string
    {
        return ResponseStatic::getLink($name, $replacement);
    }
}
