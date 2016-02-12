<?php
namespace Content\Controller;

use Conf\DB\DBDoctrine;
use CMSException\InvalidMethodException;
use Ignaszak\Registry\RegistryFactory;

class Controller
{

    /**
     *
     * @var string[]
     */
    public $entitySettersArray = [];

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     *
     * @var \Entity
     */
    protected $_entity;

    /**
     *
     * @var \Entity\Controller\EntityController
     */
    private $_entityController;

    /**
     *
     * @var SettersValidator
     */
    private $_validatorFactory;

    /**
     *
     * @var string
     */
    private $entityName;

    /**
     *
     * @param \Entity $_entity
     */
    public function __construct(
        $_entity,
        Validator\Schema\Validation $_schema = null
    ) {
        $this->_entity = $_entity;
        $this->entityName = get_class($this->_entity);
        $this->_em = DBDoctrine::em();
        $this->_entityController = RegistryFactory::start()
            ->register('Entity\Controller\EntityController');

        if (is_null($_schema)) {
            $_schema = new Validator\Schema\Validation();
        }
        $this->_validatorFactory = new Validator\ValidatorFactory($this, $_schema);
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @return Controller
     */
    public function __call(string $name, array $arguments): Controller
    {
        $this->saveEntitySetter($name, $arguments);

        return $this;
    }

    /**
     *
     * @param string $string
     * @return string
     */
    public function getAlias(string $string): string
    {
        $_alias = new Alias($this->_entity);
        return $_alias->getAlias($string);
    }

    /**
     *
     * @return \Entity
     */
    public function entity()
    {
        return $this->_entity;
    }

    /**
     *
     * @param string $entityName
     * @param int $by
     * @return Controller
     */
    public function setReference(string $entityName, int $by): Controller
    {
        $entityClass = $this->_entityController->getEntity($entityName);
        $entityObject = $this->_em->find($entityClass, $by);
        $name = "set" . ucfirst($entityName);
        $this->saveEntitySetter($name, [$entityObject]);

        return $this;
    }

    /**
     *
     * @param int $id
     * @return Controller
     */
    public function find(int $id): Controller
    {
        $this->_entity = $this->_em->getReference($this->entityName, $id);

        return $this;
    }

    /**
     *
     * @param array $array
     * @return Controller
     */
    public function findOneBy(array $array): Controller
    {
        $this->_entity = $this->_em->getRepository($this->entityName)
            ->findOneBy($array);

        return $this;
    }

    /**
     *
     * @param array $array
     * @return Controller
     */
    public function findBy(array $array): Controller
    {
        $this->_entity = $this->_em->getRepository($this->entityName)
            ->findBy($array);

        return $this;
    }

    /**
     *
     * @param array $array
     * @return Controller
     */
    public function insert(array $array = []): Controller
    {
        $this->_validatorFactory->valid($array);
        $this->callEntitySettersFromArray();
        $this->_em->persist($this->_entity);
        $this->_em->flush();

        return $this;
    }

    /**
     *
     * @param array $array
     * @return Controller
     */
    public function update(array $array = []): Controller
    {
        $this->_validatorFactory->valid($array);
        $this->callEntitySettersFromArray();
        $this->_em->persist($this->_entity);
        $this->_em->flush();

        return $this;
    }

    /**
     * @return Controller
     */
    public function remove(): Controller
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

        return $this;
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @throws InvalidMethodException
     */
    protected function saveEntitySetter(string $name, array $arguments)
    {
        if (method_exists($this->_entity, $name)) {
            $this->entitySettersArray[$name] = @$arguments[0];
        } else {
            throw new InvalidMethodException("Method '$name' does not exist");
        }
    }

    protected function callEntitySettersFromArray()
    {
        foreach ($this->entitySettersArray as $name => $arguments) {
            $this->_entity->$name($arguments);
        }
    }
}
