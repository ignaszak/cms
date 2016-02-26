<?php
namespace Entity\Controller;

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
     * @throws \RuntimeException
     */
    public function addEntity(string $name, string $entity)
    {
        if (class_exists($entity)) {
            if (! array_key_exists($name, self::$entityArray)) {
                self::$entityArray[$name] = $entity;
            }
        } else {
            throw new \RuntimeException('Entity not exists');
        }
    }

    /**
     *
     * @param string $key
     * @throws \InvalidArgumentException
     * @return string
     */
    public function getEntity(string $key): string
    {
        if (array_key_exists($key, self::$entityArray)) {
            return self::$entityArray[$key];
        } else {
            throw new \InvalidArgumentException('Invalid entity name');
        }
    }

    /**
     *
     * @param string $name
     * @return string
     */
    public function getEntityKey(string $name): string
    {
        foreach (self::$entityArray as $key => $entity) {
            if (strpos($name, $entity) !== false) {
                return $key;
            }
        }
        return '';
    }
}
