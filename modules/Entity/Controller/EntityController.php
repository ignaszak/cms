<?php

namespace Entity\Controller;

use CMSException\DBException;

class EntityController
{

    /**
     * @var Entity[]
     */
    private static $entityArray = array();

    public function __construct()
    {
        $this->addEntity('post', 'Entity\Posts');
        $this->addEntity('category', 'Entity\Categories');
        $this->addEntity('user', 'Entity\Users');
        $this->addEntity('author', 'Entity\Users');
        $this->addEntity('options', 'Entity\Options');
        $this->addEntity('page', 'Entity\Pages');
    }

    /**
     * @param string $name
     * @param string $entity
     */
    public function addEntity(string $name, string $entity)
    {
        
        if (class_exists($entity)) {
            if (!array_key_exists($name, self::$entityArray))
                self::$entityArray[$name] = $entity;
        } else {
            throw new DBException('Entity not exists');
        }
    }

    /**
     * @param string $name
     * @throws DBException
     * @return Entity
     */
    public function getEntity(string $name)
    {
        if (array_key_exists($name, self::$entityArray)) {
            return self::$entityArray[$name];
        } else {
            throw new DBException('Invalid entity name');
        }
    }

}
