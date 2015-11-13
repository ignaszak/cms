<?php

namespace Display;

use Conf\Conf;

class DisplayFactory
{

    private $_displayExtension;
    private $_conf;
    private $_instancesArray = array();

    public function __construct()
    {
        $this->_displayExtension = new DisplayExtension;
        $this->_conf = Conf::instance();
    }

    public function __call($name, $arguments)
    {
        $extensionClassName = $this->_displayExtension->returnExtensionClassName($name);
        $this->getExtensionInstance($extensionClassName);

        if (method_exists($this->_instancesArray[$extensionClassName], $name)) {

            return call_user_func_array(array(
                $this->getExtensionInstance($extensionClassName),
                $name
            ), $arguments);

        } else {

            throw new \Exception("No class correspond to <b>$name</b> match");

        }
    }

    public function display()
    {
        $contentClass = $this->_displayExtension->returnExtensionClassName('Content');
        $contentName = \Ignaszak\Router\Client::getRoute();
        $_contentInstance = $this->getExtensionInstance($contentClass);
        $_contentInstance->setContent($contentName);

        return $_contentInstance->getContent();
    }

    private function getExtensionInstance($extensionClassName)
    {
        if (empty($this->_instancesArray[$extensionClassName]))
            $this->_instancesArray[$extensionClassName] = new $extensionClassName();

        return $this->_instancesArray[$extensionClassName];
    }

}
