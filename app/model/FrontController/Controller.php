<?php
namespace FrontController;

use Ignaszak\Registry\RegistryFactory;

abstract class Controller
{

    /**
     *
     * @var ControllerHelper
     */
    private static $_controllerHelper;

    /**
     *
     * @var \Ignaszak\Registry\RegistryFactory
     */
    private static $registry;

    /**
     *
     * @var \App\Resource\Http
     */
    private static $http = null;

    /**
     *
     * @return Controller
     */
    public static function instance(): Controller
    {
        $_controller = new static();
        self::$_controllerHelper = new ControllerHelper($_controller);
        self::$registry = RegistryFactory::start();
        self::$http = self::$registry->get('http');
        return $_controller;
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array(
            [self::$_controllerHelper, $name],
            $arguments
        );
    }

    /**
     *
     * @param string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        return self::$$poperty;
    }

    /**
     * Init after Controller::run()
     */
    public function runModules()
    {
        $this->loadViewHelperSetter();
    }

    /**
     *
     * @return \View\View
     */
    public function view(): \View\View
    {
        return RegistryFactory::start()->get('view');
    }

    /**
     *
     * @return \DataBase\Query\Query
     */
    public function query(): \DataBase\Query\Query
    {
        return RegistryFactory::start()->register('DataBase\Query\Query');
    }

    /**
     *
     * @return \App\Resource\Route
     */
    public function router()
    {
        return self::$http->router;
    }

    abstract public function run();
}
