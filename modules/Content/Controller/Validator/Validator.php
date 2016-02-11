<?php
namespace Content\Controller\Validator;

use Content\Controller\Controller;

abstract class Validator
{

    /**
     *
     * @var Controller
     */
    protected $_controller;

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

    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
        $this->entityName = get_class($this->_controller->entity());
    }

    /**
     *
     * @param array $command
     */
    abstract public function valid(array $command);

    /**
     *
     * @return \Content\Controller\Validator\string[]
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
        foreach ($this->_controller->entitySettersArray as $setter => $value) {
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
