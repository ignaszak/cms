<?php
namespace Test\Init;

use Entity\Controller\EntityController;
use Ignaszak\Registry\RegistryFactory;

class InitEntityController
{

    /**
     * Inserts mock entity to \Entity\Controller\EntityController
     *
     * @param string $name
     * @param string|Entity $stub
     */
    public static function mock(string $name, $stub)
    {
        $entityController = RegistryFactory::start()->register('Entity\Controller\EntityController');
        if (is_object($stub)) {
            $stub = get_class($stub);
        }
        $entityController->addEntity($name, $stub);
    }
}
