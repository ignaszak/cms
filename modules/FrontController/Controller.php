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
     * @throws InvalidClassException
     * @return mixed|null
     */
    public function __call(string $name, array $arguments)
    {
        if (method_exists(self::$_controllerHelper, $name)) {

            return call_user_func_array(array(
                self::$_controllerHelper,
                $name
            ), $arguments);

        } else {

            throw new InvalidClassException("No class correspond to <b>$name</b> method");

        }
        return null;
    }

    public function runModules()
    {
        $this->loadViewHelperSetter();
    }

}
