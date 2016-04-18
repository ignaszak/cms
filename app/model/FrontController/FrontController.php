<?php
namespace FrontController;

use Controller\DefaultController;
use App\Resource\Http;

class FrontController
{

    /**
     * Used to check inheritance with user defined controller class
     *
     * @var \ReflectionClass('\FrontController\Controller')
     */
    private $_base = null;

    /**
     * Default controller class
     *
     * @var string
     */
    private $_default = 'Controller\DefaultController';

    /**
     *
     * @param Http $http
     */
    public function __construct(Http $http)
    {
        $this->_base = new \ReflectionClass('\FrontController\Controller');
        $this->loadController(
            empty($http->router->controller()) ?
                $this->_default : $http->router->controller()
        );
    }

    /**
     * Implements user controller class
     *
     * @param string $controllerClass
     * @throws \RuntimeException
     * @return boolean
     */
    private function loadController(string $controllerClass): bool
    {
        if (class_exists($controllerClass)) {
            $reflectionControllerClass = new \ReflectionClass($controllerClass);

            if ($reflectionControllerClass->isSubclassOf($this->_base)) {
                $controller = $controllerClass::instance();
                $controller->run();
                $controller->runModules();
                return true;
            } else {
                throw new \RuntimeException(
                    "{$controllerClass} must be a subclass of" .
                    "FrontController\Controller"
                );
            }
        }
        return false;
    }
}
