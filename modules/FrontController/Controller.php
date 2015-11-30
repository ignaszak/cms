<?php

namespace FrontController;

abstract class Controller
{

    /**
     * @var Controller
     */
    private static $_instance;

    /**
     * @return Controller
     */
    public static function instance()
    {
        //if (empty(self::$_instance))
            //self::$_instance = new static;

        return new static;
    }

    abstract public function run();

}
