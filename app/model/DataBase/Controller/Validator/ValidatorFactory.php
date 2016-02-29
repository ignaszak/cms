<?php
namespace DataBase\Controller\Validator;

use App\Resource\Server;
use DataBase\Controller\Controller;

class ValidatorFactory
{

    /**
     *
     * @var Controller
     */
    private $_controller;

    /**
     *
     * @var SettersValidator
     */
    private $_settersValidator;

    /**
     *
     * @var array
     */
    private $errorArray = [];

    /**
     *
     * @param Controller $_controller
     * @param Schema\Validation $_schema
     */
    public function __construct(Controller $_controller, Schema\Validation $_schema)
    {
        $this->_controller = $_controller;
        $this->_settersValidator = new SettersValidator($_controller, $_schema);
    }

    /**
     *
     * @param array $command
     */
    public function valid(array $command)
    {
        $this->_settersValidator->valid($command);
        $this->addErrors($this->_settersValidator->getErrors());
        $this->runValidator(
            $this->transformCommand($command)
        );
        $this->sendErrorsIfExists();
    }

    /**
     *
     * @param array $array
     */
    private function transformCommand(array $array): array
    {
        $command = [];
        foreach ($array as $setter => $commands) {
            if (is_array($commands)) {
                foreach ($commands as $operator => $value) {
                    $operator = is_int($operator) ? $value : $operator;
                    if (is_array($value)) {
                        $command[$operator][$setter] = $value;
                    } else {
                        $command[$operator][] = $setter;
                    }
                }
            }
        }
        return $command;
    }

    /**
     *
     * @param array $command
     */
    private function runValidator(array $command)
    {
        foreach ($command as $class => $commandArray) {
            if (! defined('TEST')) {
                $namespace = __NAMESPACE__ . '\\';
            }
            $className = @$namespace . ucfirst($class) . 'Validator';
            $validator = new $className($this->_controller);
            $validator->valid($commandArray);
            $this->addErrors($validator->getErrors());
        }
    }

    private function sendErrorsIfExists()
    {
        if (count($this->errorArray)) {
            foreach ($this->_controller->entitySettersArray as $key => $data) {
                // Repleca reference entities instances to its referenced id
                if (is_object($data)) {
                    if (method_exists($data, 'getId')) {
                        $this->_controller->entitySettersArray[$key] = $data->getId();
                    } else {
                        unset($this->_controller->entitySettersArray[$key]);
                    }
                }
            }

            Server::setReferData(array(
                'data' => $this->_controller->entitySettersArray,
                'error' => $this->errorArray
            ));
            Server::headerLocationReferer();
        }
    }

    /**
     *
     * @param array $errors
     */
    private function addErrors(array $errors)
    {
        $this->errorArray = array_merge(
            $this->errorArray,
            $errors
        );
    }
}
