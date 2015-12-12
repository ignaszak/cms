<?php

namespace FrontController;

abstract class Controller
{

    /**
     * @return Controller
     */
    public static function instance()
    {
        return new static;
    }

    abstract public function run();

}
