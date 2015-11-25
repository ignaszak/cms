<?php

namespace Content\Controller;

class Factory
{

    private $_controller;

    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
    }

    public function __call($name, $arguments)
    {
        $this->_controller->setToDataArray($name, $arguments);
    }
    
    public function insert()
    {
        return $this->_controller->insert();
    }

}
