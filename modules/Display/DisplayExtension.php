<?php

namespace Display;

use Ignaszak\Registry\RegistryFactory;

class DisplayExtension
{

    /**
     * List of defined extension classes
     * 
     * @var unknown
     */
    private static $extensionClassNameArray = array();

    /**
     * @param string $extensionClassName
     * @return object
     */
    public function getExtensionInstanceFromMethodName($name)
    {
        $extensionClassName = $this->returnExtensionClassNameFromMethodName($name);

        return RegistryFactory::start()->register($extensionClassName);
    }

    /**
     * Adds new extension classes to $extensionClassNameArray
     * 
     * @param (string|array) $class
     */
    public static function addExtensionClass($class)
    {
        self::$extensionClassNameArray = array_merge(
            self::$extensionClassNameArray,
            (is_array($class) ? $class : array($class))
        );
    }

    /**
     * @param string $name
     * @return string
     */
    private function returnExtensionClassNameFromMethodName($name)
    {
        // From this class script will search for no matched methods
        $className = 'Display\Extension\System';

        foreach (self::$extensionClassNameArray as $class) {

            if (preg_match("/({$this->getClassNameWithoutNamespace($class)})/", $name))
                $className = $class;
        }

        return $className;
    }

    /**
     * @param string $className
     * @return string
     */
    private function getClassNameWithoutNamespace($className)
    {
        return @end(explode('\\', $className));
    }

}
