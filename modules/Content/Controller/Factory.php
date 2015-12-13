<?php

namespace Content\Controller;

class Factory
{

    /**
     * @var Controller
     */
    private $_controller;

    /**
     * @var Alias
     */
    private $_alias;

    /**
     * @param Controller $_controller
     */
    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
        $this->_alias = new Alias($this->_controller->getEntity());
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments)
    {
        $this->_controller->setToDataArray($name, $arguments);
    }

    /**
     * @param string $entityName
     * @param int $by
     */
    public function setReference(string $entityName, int $by)
    {
        $this->_controller->setReference($entityName, $by);
    }
    
    /**
     * @param string $string
     * @return string
     */
    public function getAlias(string $string): string
    {
        return $this->_alias->getAlias($string);
    }

    /**
     * @param int $id
     */
    public function find(int $id)
    {
        $this->_controller->find($id);
    }

    public function insert()
    {
        $this->_controller->insert();
    }

}
