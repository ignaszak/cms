<?php
namespace DataBase\Command\Validator;

use DataBase\Command\Command;
use Ignaszak\Registry\RegistryFactory;

abstract class Validator
{

    /**
     *
     * @var Command
     */
    protected $command = null;

    /**
     *
     * @var Ignaszak\Registry\RegistryFactory::start()
     */
    protected $registry = null;

    /**
     *
     * @var string[]
     */
    protected $commandArray = [];

    /**
     *
     * @var string[]
     */
    protected $errorArray = [];

    /**
     *
     * @var string
     */
    protected $entityName;

    public function __construct(Command $command)
    {
        $this->command = $command;
        $this->registry = RegistryFactory::start();
        $this->entityName = get_class($this->command->entity());
    }

    /**
     *
     * @param array $command
     */
    abstract public function valid(array $command);

    /**
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errorArray;
    }

    /**
     *
     * @param string $name
     * @return mixed
     */
    protected function getSetter(string $name)
    {
        foreach ($this->command->entityMethodsArray as $setter => $value) {
            if (strpos(strtolower($setter), $name) !== false) {
                return $value;
            }
        }
        return false;
    }

    /**
     *
     * @param string $key
     */
    protected function setError(string $key)
    {
        $this->errorArray[$key] = 1;
    }
}
