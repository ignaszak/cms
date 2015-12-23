<?php

namespace Content\Controller;

class Factory
{

    /**
     * @var Controller
     */
    private $_controller;

    /**
     * @param Controller $_controller
     */
    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return Factory
     */
    public function __call($name, $arguments): Factory
    {
        $this->_controller->setToDataArray($name, $arguments);

        return $this;
    }

    /**
     * @param string $entityName
     * @param int $by
     * @return Factory
     */
    public function setReference(string $entityName, int $by): Factory
    {
        $this->_controller->setReference($entityName, $by);

        return $this;
    }

    /**
     * @param int $id
     * @return Factory
     */
    public function find(int $id): Factory
    {
        $this->_controller->find($id);

        return $this;
    }

    /**
     * @param array $array
     * @return Factory
     */
    public function findBy(array $array): Factory
    {
        $this->_controller->findBy($array);

        return $this;
    }

    /**
     * @return Factory
     */
    public function insert(): Factory
    {
        $this->_controller->insert();

        return $this;
    }

    /**
     * @return Factory
     */
    public function remove(): Factory
    {
        $this->_controller->remove();

        return $this;
    }

    /**
     * @param string $string
     * @return string
     */
    public function getAlias(string $string): string
    {
        $_alias = new Alias($this->_controller->getEntity());
        return $_alias->getAlias($string);
    }

}
