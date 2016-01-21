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
     * @return Controller
     */
    public static function instance(): Controller
    {
        $_controller = new static();
        self::$_controllerHelper = new ControllerHelper($_controller);
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
        return call_user_func_array(array(
            self::$_controllerHelper,
            $name
        ), $arguments);
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
     * @return \Content\Query\Content
     */
    public function query(): \Content\Query\Content
    {
        return RegistryFactory::start()->register('Content\Query\Content');
    }

    abstract public function run();
}
