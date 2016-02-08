<?php
namespace Content\Controller;

use Conf\DB\DBDoctrine;
use CMSException\InvalidMethodException;
use Ignaszak\Registry\RegistryFactory;

abstract class Controller
{

    /**
     *
     * @var array
     */
    public $entitySettersArray = [];

    /**
     *
     * @var EntityManager
     */
    protected $_em;

    /**
     *
     * @var Entity
     */
    protected $_entity;

    /**
     *
     * @var EntityController
     */
    private $_entityController;

    /**
     *
     * @var SettersValidator
     */
    private $_settertsValidator;

    public function __construct()
    {
        $this->_em = DBDoctrine::em();
        $this->_entityController = RegistryFactory::start()
            ->register('Entity\Controller\EntityController');
        $this->_settertsValidator = new SettersValidator($this);
    }

    /**
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     *
     * @param int $id
     */
    public function find(int $id)
    {
        $entityName = get_class($this->_entity);
        $this->_entity = $this->_em->getReference($entityName, $id);
    }

    /**
     *
     * @param array $array
     */
    public function findOneBy(array $array)
    {
        $entityName = get_class($this->_entity);
        $this->_entity = $this->_em->getRepository($entityName)->findOneBy($array);
    }

    /**
     *
     * @param array $array
     */
    public function findBy(array $array)
    {
        $entityName = get_class($this->_entity);
        $this->_entity = $this->_em->getRepository($entityName)->findBy($array);
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @throws InvalidMethodException
     */
    public function saveEntitySetter(string $name, array $arguments)
    {
        if (method_exists($this->_entity, $name)) {
            $this->entitySettersArray[$name] = @$arguments[0];
        } else {
            throw new InvalidMethodException("Method '$name' does not exist");
        }
    }

    /**
     *
     * @param string $entityName
     * @param int $by
     */
    public function setReference(string $entityName, int $by)
    {
        $entityClass = $this->_entityController->getEntity($entityName);
        $entityObject = $this->_em->find($entityClass, $by);
        $name = "set" . ucfirst($entityName);
        $this->saveEntitySetter($name, [$entityObject]);
    }

    public function remove()
    {
        if (is_array($this->_entity)) {
            foreach ($this->_entity as $entity) {
                $this->_em->remove($entity);
            }
            $this->_em->flush();
        } else {
            $this->_em->remove($this->_entity);
            $this->_em->flush($this->_entity);
        }
    }

    abstract public function insert();

    protected function validSetters(array $validPatternsArray)
    {
        $this->_settertsValidator->valid($validPatternsArray);
    }

    protected function callEntitySettersFromArray()
    {
        foreach ($this->entitySettersArray as $name => $arguments) {
            $this->_entity->$name($arguments);
        }
    }
}
