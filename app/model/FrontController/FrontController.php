<?php
namespace FrontController;

use Ignaszak\Registry\RegistryFactory;

class FrontController
{

    /**
     *
     * @var Controller
     */
    private static $_controller;

    private function __construct()
    {
    }

    /**
     *
     * @param CommandHandler $_commandHandler
     */
    public static function run(CommandHandler $_commandHandler = null)
    {
        self::instance();
        self::$_controller->handle($_commandHandler);
    }

    private static function instance()
    {
        if (empty(self::$_controller)) {
            self::$_controller = new FrontController();
        }
    }

    /**
     *
     * @param CommandHandler $_commandHandler
     */
    private function handle(CommandHandler $_commandHandler = null)
    {
        $_route = RegistryFactory::start()->register('App\Resource\Route');
        $_commandHandler = $_commandHandler ?? new CommandHandler();
        $_commandHandler->getCommand($_route);
    }
}
