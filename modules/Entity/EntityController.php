<?php

namespace Entity;

class EntityController
{

    private static $_entityController;
    private static $entityArray = array();

    public function __construct()
    {
        $this->addEntity('post', 'Entity\Posts');
        $this->addEntity('category', 'Entity\Categories');
    }

    public static function instance()
    {
        if (empty(self::$_entityController))
            self::$_entityController = new EntityController;

            return self::$_entityController;
    }

    public function addEntity($name, $entity)
    {
        if (is_string($name) && class_exists($entity) && !array_key_exists($name, self::$entityArray))
            self::$entityArray = array_merge(self::$entityArray, array($name => $entity));
    }

    public function getEntityByName($name)
    {
        if (array_key_exists($name, self::$entityArray)) {
            return self::$entityArray[$name];
        } else {
            throw new \CMSException\DBException('Invalid entity name');
        }
    }

}
