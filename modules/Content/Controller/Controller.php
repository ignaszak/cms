<?php

namespace Content\Controller;

use System\Server;
use Conf\DB\DBDoctrine;
use CMSException\InvalidMethodException;
use Validation\ContentValidation;
use Ignaszak\Registry\RegistryFactory;

abstract class Controller
{

    /**
     * @var EntityManager
     */
    protected $_em;

    /**
     * @var Entity
     */
    protected $_entity;

    /**
     * @var ContentValidation
     */
    protected $_contentValidation;

    /**
     * @var array
     */
    protected $dataArray = array();

    /**
     * @var string[]
     */
    protected $validPatternsArray = array();

    /**
     * @var EntityController
     */
    private $_entityController;

    /**
     * @var string[]
     */
    private $errorArray = array();

    public function __construct()
    {
        $this->_em = DBDoctrine::em();
        $this->_contentValidation = new ContentValidation;
        $this->_entityController = RegistryFactory::start()
            ->register('Entity\Controller\EntityController');
    }

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     * @param int $id
     */
    public function find(int $id)
    {
        $entityName = get_class($this->_entity);
        $this->_entity = $this->_em->getReference($entityName, $id);
    }

    /**
     * @param array $array
     */
    public function findBy(array $array)
    {
        $entityName = get_class($this->_entity);
        $this->_entity = $this->_em->getRepository($entityName)->findOneBy($array);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @throws InvalidMethodException
     */
    public function setToDataArray(string $name, array $arguments)
    {
        if (method_exists($this->_entity, $name)) {
            $this->dataArray[$name] = @$arguments[0];
        } else {
            throw new InvalidMethodException("Method '$name' does not exist");
        }
    }

    /**
     * @param string $entityName
     * @param int $by
     */
    public function setReference(string $entityName, int $by)
    {
        $entityClass = $this->_entityController->getEntity($entityName);
        $entityObject = $this->_em->find($entityClass, $by);
        $name = "set" . ucfirst($entityName);
        $this->setToDataArray($name, array($entityObject));
    }

    /**
     * @param array $validPatternsArray
     */
    protected function validAndAddToEntity(array $validPatternsArray)
    {
        $this->validPatternsArray = $validPatternsArray;
        $this->validData();
        $this->sendErrorsIfExists();
        $this->callEntitySetters();
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

    private function callEntitySetters()
    {
        foreach ($this->dataArray as $name => $arguments) {
            $this->_entity->$name($arguments);
        }
    }

    abstract public function insert();
    abstract public function remove();

}

