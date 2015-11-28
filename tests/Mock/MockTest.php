<?php

namespace Test\Mock;

class MockTest
{

    public static function callMockMethod($object, $method, array $args = array())
    {
        $class = new \ReflectionClass(get_class($object));
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

}
