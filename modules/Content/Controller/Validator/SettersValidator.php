<?php
namespace Content\Controller\Validator;

use System\Server;
use Content\Controller\Controller;

class SettersValidator extends Validator
{

    /**
     *
     * @var ContentValidation
     */
    private $_validation;

    public function __construct(Controller $_controller, Schema\Validation $_schema)
    {
        parent::__construct($_controller);
        $this->_validation = $_schema;
    }

    /**
     *
     * @param array $command
     */
    public function valid(array $command)
    {
        $this->commandArray = $command;
        $this->validData();
        $this->sendErrorsIfExists();
    }

    private function validData()
    {
        foreach ($this->commandArray as $pattern) {

            $this->errorArray["incorrect$pattern"] = 1;
            $method = "valid$pattern";

            foreach ($this->_controller->entitySettersArray as $name => $arguments) {

                if (strpos($name, $pattern) !== false) {

                    if ($this->_validation->$method($arguments)) {
                        unset($this->errorArray["incorrect$pattern"]);
                    }
                }
            }
        }
    }

    private function sendErrorsIfExists()
    {
        if (count($this->errorArray)) {

            foreach ($this->_controller->entitySettersArray as $key => $data) {
                if (is_object($data)) {
                    if (method_exists($data, 'getId')) {
                        $this->entitySettersArray[$key] = $data->getId();
                    } else {
                        unset($this->entitySettersArray[$key]);
                    }
                }
            }

            Server::setReferData(array(
                'data' => $this->entitySettersArray,
                'error' => $this->errorArray
            ));
            Server::headerLocationReferer();
        }
    }
}
