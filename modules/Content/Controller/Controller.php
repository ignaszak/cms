<?php

namespace Content\Controller;

use System\Server;
use Conf\DB\DBDoctrine;
use CMSException\InvalidMethodException;
use Validation\ContentValidation;
use Entity\EntityController;

abstract class Controller
{

    protected $_em;
    protected $_entity;
    protected $_contentValidation;
    private $_entityController;
    protected $dataArray = array();
    protected $validPatternsArray = array();
    private $errorArray = array();

    public function __construct()
    {
        $this->_em = DBDoctrine::em();
        $this->_contentValidation = new ContentValidation;
        $this->_entityController = EntityController::instance();
    }

    public function setToDataArray($name, $arguments)
    {
        if (method_exists($this->_entity, $name)) {
            $this->dataArray[$name] = @$arguments[0];
        } else {
            throw new InvalidMethodException("Method '$name' does not exist.");
        }
    }

    public function setReference($entityName, $by)
    {
        if (is_numeric($by)) {
            $entityClass = $this->_entityController->getEntityByName($entityName);
            $entityObject = DBDoctrine::em()->find($entityClass, $by);
        }
        $name = "set" . ucfirst($entityName);
        $this->setToDataArray($name, array($entityObject));
    }

    protected function validAndAddToEntity(array $validPatternsArray)
    {
        $this->validPatternsArray = $validPatternsArray;
        $this->validData();
        $this->sendErrorsIfExists();
        $this->callEntitySetters();
    }

    private function callEntitySetters()
    {
        foreach ($this->dataArray as $name => $arguments) {
            $this->_entity->$name($arguments);
        }
    }

    private function validData()
    {
        foreach ($this->validPatternsArray as $pattern) {

            $this->errorArray["incorrect$pattern"] = 1;
            $method = "valid$pattern";

            foreach ($this->dataArray as $name => $arguments) {

                if (strpos($name, $pattern) !== false){

                    if ($this->_contentValidation->$method($arguments))
                        unset($this->errorArray["incorrect$pattern"]);
                }
            }
        }
    }

    private function sendErrorsIfExists()
    {
        if (count($this->errorArray) > 0) {

            foreach ($this->dataArray as $key=>$data) {
                if (is_object($data)) {
                    if (method_exists($data, 'getId')) {
                        $this->dataArray[$key] = $data->getId();
                    } else {
                        unset($this->dataArray[$key]);
                    }
                }
            }

            Server::setReferData(array('data'=>$this->dataArray,'error'=>$this->errorArray));
            Server::headerLocationReferer();
        }
    }

}

