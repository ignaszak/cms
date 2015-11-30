<?php

namespace FrontController;

use System\Router\Route;

class FrontController
{

    /**
     * @var Controller
     */
    private static $_controller;

    private function __construct() {}

    /**
     * @param CommandHandler $_commandHandler
     */
    public static function run(CommandHandler $_commandHandler = null)
    {
        self::instance();
        self::$_controller->handle($_commandHandler);
    }

    private static function instance()
    {
        if (empty(self::$_controller))
            self::$_controller = new FrontController;
    }

    private function handle($_commandHandler)
    {
        $_route = new Route;
        $_commandHandler = !empty($_commandHandler) ? $_commandHandler : new CommandHandler;
        $_commandHandler->getCommand($_route);
    }

}
