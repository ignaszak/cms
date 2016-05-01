<?php
declare(strict_types=1);

namespace View;

use Ignaszak\Registry\RegistryFactory;

class ViewHelper
{

    /**
     *
     * @var \Ignaszak\Registry\Registry
     */
    private $registry = null;

    /**
     *
     * @var string[]
     */
    private $methods = [];

    public function __construct()
    {
        $this->registry = RegistryFactory::start();
    }

    /**
     *
     * @param string[] $array
     * @throws \RuntimeException
     */
    public function add(array $array)
    {
        foreach ($array as $class) {
            $methods = get_class_methods($class) ?: [];
            foreach ($methods as $method) {
                if (array_key_exists($method, $this->methods)) {
                    throw new \RuntimeException(
                        "Method '{$method}' defined in class '{$class}' " .
                        "alredy exists in class '{$this->methods[$method]}'"
                    );
                } else {
                    if (substr($method, 0, 2) !== '__') {
                        $this->methods[$method] = $class;
                    }
                }
            }
        }
    }

    /**
     *
     * @return \View\string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
