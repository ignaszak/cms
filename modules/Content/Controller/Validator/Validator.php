<?php
namespace Content\Controller\Validator;

use Content\Controller\Controller;

abstract class Validator
{

    /**
     *
     * @var Controller
     */
    protected $_controller;

    /**
     *
     * @var string[]
     */
    protected $commandArray = [];

    /**
     *
     * @var string[]
     */
    protected $errorArray = [];

    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
    }

    abstract public function valid(array $command);
}
