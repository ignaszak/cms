<?php
namespace Content\Controller\Validator;

use Content\Controller\Controller;

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
        $this->getValidator(
            $this->transformCommand($command)
        );
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
    private function getValidator(array $command)
    {
        foreach ($command as $class => $commandArray) {
            $className = ucfirst($class) . 'Validator';
            $validator = new $className($this->_controller);
            $validator->valid($commandArray);
        }
    }
}
