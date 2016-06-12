<?php
namespace DataBase\Command\Validator;

use App\Resource\Server;
use DataBase\Command\Command;

class ValidatorFactory
{

    /**
     *
     * @var Command
     */
    private $command = null;

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
     * @param Command $command
     * @param Schema\Validation $schema
     */
    public function __construct(Command $command, Schema\Validation $schema)
    {
        $this->command = $command;
        $this->settersValidator = new SettersValidator($command, $schema);
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
            $validator = new $className($this->command);
            $validator->valid($commandArray);
            $this->addErrors($validator->getErrors());
        }
    }

    private function sendErrorsIfExists()
    {
        if (count($this->errorArray)) {
            foreach ($this->command->entitySettersArray as $key => $data) {
                // Repleca reference entities instances to its referenced id
                if (is_object($data)) {
                    if (method_exists($data, 'getId')) {
                        $this->command->entitySettersArray[$key] = $data->getId();
                    } else {
                        unset($this->command->entitySettersArray[$key]);
                    }
                }
            }

            Server::setReferData(array(
                'data' => $this->command->entitySettersArray,
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
