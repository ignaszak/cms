<?php
namespace Test\Mock;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class MockTest
{

    /**
     *
     * @var vfsStream
     */
    private static $vfsStreamRoot = null;

    /**
     *
     * @param object|string $object
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public static function callMockMethod(
        $object,
        string $method,
        array $args = []
    ) {
        $class = new \ReflectionClass(
            is_object($object) ? get_class($object) : $object
        );
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        $object = is_object($object) ? $object : $class;
        return $method->invokeArgs($object, $args);
    }

    /**
     *
     * @param $object
     * @param string $name
     * @return mixed
     */
    public function property($object, string $name)
    {
        return \PHPUnit_Framework_Assert::readAttribute($object, $name);
    }

    /**
     *
     * @param string $file
     * @param string $content
     */
    public static function mockFile(
        string $file,
        int $chmod = 0644,
        string $content = ""
    ): string {
        if (empty(self::$vfsStreamRoot)) {
            self::$vfsStreamRoot = vfsStream::setup('mock');
        }
        vfsStream::newFile($file, $chmod)
            ->at(self::$vfsStreamRoot)->withContent($content);
        return vfsStream::url("mock/$file");
    }

    /**
     *
     * @param array $structure
     * @return string
     */
    public static function mockFileSystem(array $structure): string
    {
        if (empty(self::$vfsStreamRoot)) {
            self::$vfsStreamRoot = vfsStream::setup('mock');
        }
        vfsStream::create($structure, self::$vfsStreamRoot);
        return vfsStream::url('mock');
    }

    /**
     *
     * @param string $dir
     * @return string
     */
    public static function mockDir(string $dir): string
    {
        $root = vfsStream::newDirectory($dir);
        vfsStreamWrapper::setRoot($root);
        return vfsStream::url($dir);
    }

    /**
     *
     * @param object $class
     * @param string $property
     * @param mixed $value
     */
    public static function inject($object, string $property, $value = null)
    {
        $class = $object;
        if (is_object($object)) {
            $class = get_class($object);
        }
        $reflection = new \ReflectionProperty($class, $property);
        $reflection->setAccessible(true);
        $reflection->setValue($object, $value);
    }

    /**
     *
     * @param string|object $class
     * @param string $property
     * @param mixed $value
     */
    public static function injectStatic($class, string $property, $value = null)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        $reflection = new \ReflectionProperty($class, $property);
        $reflection->setAccessible(true);
        $reflection->setValue(null, $value);
    }
}
