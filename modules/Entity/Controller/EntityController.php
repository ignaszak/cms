<?php
namespace Entity\Controller;

use CMSException\DBException;

class EntityController
{

    /**
     *
     * @var Entity[]
     */
    private static $entityArray = [];

    public function __construct()
    {
        $this->addEntity('post', 'Entity\Posts');
        $this->addEntity('category', 'Entity\Categories');
        $this->addEntity('user', 'Entity\Users');
        $this->addEntity('author', 'Entity\Users');
        $this->addEntity('options', 'Entity\Options');
        $this->addEntity('page', 'Entity\Pages');
        $this->addEntity('menu', 'Entity\Menus');
        $this->addEntity('menuItems', 'Entity\MenuItems');
    }

    /**
     *
     * @param string $name
     * @param string $entity
     */
    public function addEntity(string $name, string $entity)
    {
        if (class_exists($entity)) {
            if (! array_key_exists($name, self::$entityArray)) {
                self::$entityArray[$name] = $entity;
            }
        } else {
            throw new DBException('Entity not exists');
        }
    }

    /**
     *
     * @param string $name
     * @throws DBException
     * @return string
     */
    public function getEntity(string $key): string
    {
        if (array_key_exists($key, self::$entityArray)) {
            return self::$entityArray[$key];
        } else {
            throw new DBException('Invalid entity name');
        }
    }

    /**
     *
     * @param string $name
     * @return string
     */
    public function getEntityKey(string $name): string
    {
        return array_search($name, self::$entityArray) ?? '';
    }
}
