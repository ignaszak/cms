<?php

namespace FrontController;

use Ignaszak\Registry\RegistryFactory;
use ViewHelper\ViewHelperExtension;

class ControllerHelper
{

    /**
     * @var Controller
     */
    private $_controller;

    /**
     * @var ViewHelper
     */
    private $_viewHelper;

    /**
     * @var string
     */
    private $viewHelperName;

    /**
     * @param Controller $_controller
     */
    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
        $this->_viewHelper = RegistryFactory::start()->register('ViewHelper\ViewHelper');
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array(array(
            $this->_viewHelper,
            $name
        ), $arguments);
    }

    /**
     * @param string $name
     */
    public function setViewHelperName(string $name)
    {
        $this->viewHelperName = $name;
    }

    /**
     * @return boolean
     */
    public function loadViewHelperSetter(): bool
    {
        if (method_exists($this->_controller, 'setViewHelper')) {
            RegistryFactory::start()->set($this->viewHelperName, $this->_controller->setViewHelper());
            ViewHelperExtension::addExtensionClass($this->viewHelperName);
            return true;
        }
        return false;
    }

}
