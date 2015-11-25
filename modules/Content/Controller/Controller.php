<?php

namespace Content\Controller;

use Conf\DB\DBDoctrine;
use CMSException\InvalidMethodException;
use Validation\ContentValidation;

abstract class Controller
{

    protected $_em;
    protected $_entity;
    protected $_contentValidation;
    protected $dataArray = array();
    protected $validPatternsArray = array();
    private $errorArray = array();

    public function __construct()
    {
        $this->_em = DBDoctrine::getEntityManager();
        $this->_contentValidation = new ContentValidation;
    }

    public function setToDataArray($name, $arguments)
    {
        if (method_exists($this->_entity, $name)) {
            $this->dataArray[$name] = @$arguments[0];
        } else {
            throw new InvalidMethodException("Method '$name' does not exist.");
        }
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
            //echo "$name => $arguments<br>";
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
            \System\Server::setReferData(array('data'=>$this->dataArray,'error'=>$this->errorArray));
            \System\Server::headerLocationReferer();
        }
    }

}

