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
    private $controller = null;

    /**
     *
     * @var SettersValidator
     */
    private $settersValidator = null;

    /**
     *
     * @var array
     */
    private $errorArray = [];

    /**
     *
     * @param Controller $controller
     * @param Schema\Validation $schema
     */
    public function __construct(Controller $controller, Schema\Validation $schema)
    {
        $this->controller = $controller;
        $this->settersValidator = new SettersValidator($controller, $schema);
    }

    /**
     *
     * @param array $command
     */
    public function valid(array $command)
    {
        $this->settersValidator->valid($command);
        $this->addErrors($this->settersValidator->getErrors());
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
            $namespace = !defined('TEST') ? __NAMESPACE__ . '\\' : '';
            $className = $namespace . ucfirst($class) . 'Validator';
            $validator = new $className($this->controller);
            $validator->valid($commandArray);
            $this->addErrors($validator->getErrors());
        }
    }

    private function sendErrorsIfExists()
    {
        if (count($this->errorArray)) {
            foreach ($this->controller->entitySettersArray as $key => $data) {
                // Repleca reference entities instances to its referenced id
                if (is_object($data)) {
                    if (method_exists($data, 'getId')) {
                        $this->controller->entitySettersArray[$key] = $data->getId();
                    } else {
                        unset($this->controller->entitySettersArray[$key]);
                    }
                }
            }

            Server::setReferData(array(
                'data' => $this->controller->entitySettersArray,
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
