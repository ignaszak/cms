<?php
namespace DataBase\Controller;

use Conf\DB\DBDoctrine;
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
    protected $em = null;

    /**
     *
     * @var \Entity
     */
    protected $entity = null;

    /**
     *
     * @var \Entity\Controller\EntityController
     */
    private $entityController = null;

    /**
     *
     * @var SettersValidator
     */
    private $validatorFactory = null;

    /**
     *
     * @var string
     */
    private $entityName = '';

    /**
     *
     * @param \Entity $entity
     * @param Validator\Schema\Validation $schema
     */
    public function __construct(
        $entity,
        Validator\Schema\Validation $schema = null
    ) {
        $this->entity = $entity;
        $this->entityName = get_class($this->entity);
        $this->em = DBDoctrine::em();
        $this->entityController = RegistryFactory::start()
            ->register('Entity\Controller\EntityController');

        if (is_null($schema)) {
            $schema = new Validator\Schema\Validation();
        }
        $this->validatorFactory = new Validator\ValidatorFactory($this, $schema);
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
        $alias = new Alias($this->entity);
        return $alias->getAlias($string);
    }

    /**
     *
     * @return \Entity
     */
    public function entity()
    {
        return $this->entity;
    }

    /**
     *
     * @param string $entityName
     * @param int $by
     * @return Controller
     */
    public function setReference(string $entityName, int $by): Controller
    {
        $entityClass = $this->entityController->getEntity($entityName);
        $entityObject = $this->em->find($entityClass, $by);
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
        $this->entity = $this->em->getReference($this->entityName, $id);

        return $this;
    }

    /**
     *
     * @param array $array
     * @return Controller
     */
    public function findOneBy(array $array): Controller
    {
        $this->entity = $this->em->getRepository($this->entityName)
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
        $this->entity = $this->em->getRepository($this->entityName)
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
        $this->validatorFactory->valid($array);
        $this->callEntitySettersFromArray();
        $this->em->persist($this->entity);
        $this->em->flush();

        return $this;
    }

    /**
     *
     * @param array $array
     * @return Controller
     */
    public function update(array $array = []): Controller
    {
        $this->validatorFactory->valid($array);
        $this->callEntitySettersFromArray();
        $this->em->persist($this->entity);
        $this->em->flush();

        return $this;
    }

    /**
     * @return Controller
     */
    public function remove(): Controller
    {
        if (is_array($this->entity)) {
            foreach ($this->entity as $entity) {
                $this->em->remove($entity);
            }
            $this->em->flush();
        } else {
            $this->em->remove($this->entity);
            $this->em->flush($this->entity);
        }

        return $this;
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @throws \BadMethodCallException
     */
    protected function saveEntitySetter(string $name, array $arguments)
    {
        if (method_exists($this->entity, $name)) {
            $this->entitySettersArray[$name] = @$arguments[0];
        } else {
            throw new \BadMethodCallException("Method '$name' does not exist");
        }
    }

    protected function callEntitySettersFromArray()
    {
        foreach ($this->entitySettersArray as $name => $arguments) {
            $this->entity->$name($arguments);
        }
    }
}
