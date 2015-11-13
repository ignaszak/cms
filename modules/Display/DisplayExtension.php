<?php

namespace Display;

class DisplayExtension
{

    private static $extensionClassNameArray = array();

    public function returnExtensionClassName($name)
    {
        $className = '\\Display\Extension\\System';

        foreach (self::$extensionClassNameArray as $class) {

            if (preg_match("/({$this->getClassNameWithoutNamespace($class)})/", $name))
                $className = $class;

        }

        return $className;
    }

    public static function addExtensionClass($class)
    {
        self::$extensionClassNameArray = array_merge(
            self::$extensionClassNameArray,
            (is_array($class) ? $class : array($class))
        );
    }

    private function getClassNameWithoutNamespace($className)
    {
        return end(@explode('\\', $className));
    }

}
