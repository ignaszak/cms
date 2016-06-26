<?php
namespace DataBase\Command;

use Conf\DB\DBDoctrine;
use Doctrine\ORM\EntityManager;
use Ignaszak\Registry\RegistryFactory;

class Command
{

    /**
     *
     * @var string[]
     */
    public $entityMethodsArray = [];

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
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->initEntityMethod($name, $arguments);
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
     * @return EntityManager
     */
    public function em(): EntityManager
    {
        return $this->em;
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
    public function setReference(string $entityName, int $by): Command
    {
        $entityClass = $this->entityController->getEntity($entityName);
        $entityObject = $this->em->find($entityClass, $by);
        $name = "set" . ucfirst($entityName);
        $this->initEntityMethod($name, [$entityObject]);

        return $this;
    }

    /**
     *
     * @param int $id
     * @return Controller
     */
    public function find(int $id): Command
    {
        $this->entity = $this->em->getReference($this->entityName, $id);

        return $this;
    }

    /**
     *
     * @param array $array
     * @return Controller
     */
    public function findOneBy(array $array): Command
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
    public function findBy(array $array): Command
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
    public function insert(array $array = []): Command
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
    public function update(array $array = []): Command
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
    public function remove(): Command
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
     * @return mixed
     */
    protected function initEntityMethod(string $name, array $arguments)
    {
        $prefix = substr($name, 0, 3);
        $key = substr($name, 3);
        if (method_exists($this->entity, $name)) {
            if ($prefix === 'set') {
                $this->entityMethodsArray[$key] = @$arguments[0];
                return $this;
            } else {
                return $this->entityMethodsArray[$key] ?? null;
            }
        } else {
            throw new \BadMethodCallException("Method '{$name}' does not exist");
        }
    }

    protected function callEntitySettersFromArray()
    {
        foreach ($this->entityMethodsArray as $name => $arguments) {
            $name = "set{$name}";
            $this->entity->$name($arguments);
        }
    }
}
