<?php

namespace Display;

use Conf\Conf;
use System\Router\Storage as Router;
use CMSException\InvalidClassException;
use Doctrine\ORM\Internal\Hydration\ObjectHydrator;

class DisplayFactory
{

    /**
     * @var DisplayExtension
     */
    private $_displayExtension;

    /**
     * @var Conf
     */
    private $_conf;

    /**
     * Contains extension instances
     * 
     * @var array
     */
    private $_instancesArray = array();

    public function __construct()
    {
        $this->_displayExtension = new DisplayExtension;
        $this->_conf = Conf::instance();
    }

    /**
     * Searches for correspond class based on method name.
     * If is found creates an object and call a method.
     * 
     * @param string $name
     * @param array $arguments
     * @throws InvalidClassException
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $extensionInstance = $this->_displayExtension->getExtensionInstanceFromMethodName($name);

        if (method_exists($extensionInstance, $name)) {

            return call_user_func_array(array(
                $extensionInstance,
                $name
            ), $arguments);

        } else {

            throw new InvalidClassException("No class correspond to <b>$name</b> method");

        }
        return null;
    }

    /**
     * Returns current entity based on client request
     * 
     * @return array
     */
    public function display()
    {
        $_contentInstance = $this->_displayExtension->getExtensionInstanceFromMethodName('Content');
        $contentName = Router::getRoute();
        $_contentInstance->setContent($contentName);

        return $_contentInstance->getContent();
    }

}
