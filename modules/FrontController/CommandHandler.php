<?php

namespace FrontController;

use System\Router\Route;
use CMSException\InvalidControllerException;
use Controller\DefaultController;

class CommandHandler
{

    /**
     * Used to check inheritance with user defined controller class
     * 
     * @var \ReflectionClass('\FrontController\Controller')
     */
    private $_base;

    /**
     * 
     * @var DefaultController
     */
    private $_default;

    public function __construct()
    {
        $this->_base = new \ReflectionClass('\FrontController\Controller');
        $this->_default = 'Controller\DefaultController';
    }

    /**
     * Implements user controller class when is defined, exists and is child of Controller
     * 
     * @param Route $_route
     * @throws InvalidControllerException
     * @return boolean
     */
    public function getCommand(Route $_route): bool
    {
        if ($_route->controller) {
            $controllerClass = $_route->controller;
            return $this->loadController($controllerClass);
        } else {
            return $this->loadController($this->_default);
        }
    }

    private function loadController(string $controllerClass): bool
    {
        if (class_exists($controllerClass)) {
            $reflectionControllerClass = new \ReflectionClass($controllerClass);
        
            if ($reflectionControllerClass->isSubclassOf($this->_base)) {
                $controller = $controllerClass::instance();
                $controller->setUp();
                $controller->run();
                $controller->runModules();
                return true;
            } else {
                throw new InvalidControllerException("$controllerClass must be a subclass of FrontController\Controller");
            }
        }
        return false;
    }

}
