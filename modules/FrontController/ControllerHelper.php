<?php
namespace FrontController;

use Ignaszak\Registry\RegistryFactory;
use ViewHelper\ViewHelperExtension;

class ControllerHelper
{

    /**
     *
     * @var Controller
     */
    private $_controller;

    /**
     *
     * @var string
     */
    private $viewHelperName;

    /**
     *
     * @param Controller $_controller
     */
    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
    }

    /**
     *
     * @param string $name
     */
    public function setViewHelperName(string $name)
    {
        $this->viewHelperName = $name;
    }

    /**
     *
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
