<?php

namespace FrontController;

use Ignaszak\Registry\RegistryFactory;

abstract class Controller
{

    /**
     * @var ControllerHelper
     */
    private static $_controllerHelper;

    /**
     * @var \View\View
     */
    protected $_view;

    /**
     * @return Controller
     */
    public static function instance(): Controller
    {
        $_controller = new static;
        self::$_controllerHelper = new ControllerHelper($_controller);
        return $_controller;
    }

    /**
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
     * Init before Controller::run()
     */
    public function setUp()
    {
        $this->_view = RegistryFactory::start()->get('view');
    }

    abstract public function run();

    /**
     * Init after Controller::run()
     */
    public function runModules()
    {
        $this->loadViewHelperSetter();
    }

    /**
     * @return \View\View
     */
    public function view(): \View\View
    {
        return $this->_view;
    }

}
