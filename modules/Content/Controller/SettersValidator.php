<?php
namespace Content\Controller;

use System\Server;
use Validation\ContentValidation;

class SettersValidator
{

    /**
     *
     * @var Controller
     */
    private $_controller;

    /**
     *
     * @var ContentValidation
     */
    private $_contentValidation;

    /**
     *
     * @var string[]
     */
    private $validPatternsArray = [];

    /**
     *
     * @var string[]
     */
    private $errorArray = [];

    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
        $this->_contentValidation = new ContentValidation;
    }

    /**
     *
     * @param array $validPatternsArray
     */
    public function valid(array $validPatternsArray)
    {
        $this->validPatternsArray = $validPatternsArray;
        $this->validData();
        $this->sendErrorsIfExists();
    }

    private function validData()
    {
        foreach ($this->validPatternsArray as $pattern) {

            $this->errorArray["incorrect$pattern"] = 1;
            $method = "valid$pattern";

            foreach ($this->_controller->entitySettersArray as $name => $arguments) {

                if (strpos($name, $pattern) !== false) {

                    if ($this->_contentValidation->$method($arguments)) {
                        unset($this->errorArray["incorrect$pattern"]);
                    }
                }
            }
        }
    }

    private function sendErrorsIfExists()
    {
        if (count($this->errorArray) > 0) {

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
