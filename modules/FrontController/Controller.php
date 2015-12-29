<?php

namespace FrontController;

use CMSException\InvalidClassException;

abstract class Controller
{

    /**
     * @var ControllerHelper
     */
    private static $_controllerHelper;

    /**
     * @return Controller
     */
    public static function instance(): Controller
    {
        $_controller = new static;
        self::$_controllerHelper = new ControllerHelper($_controller);
        return $_controller;
    }

    abstract public function run();

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

    public function runModules()
    {
        $this->loadViewHelperSetter();
    }

}
