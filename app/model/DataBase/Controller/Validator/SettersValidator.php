<?php
namespace DataBase\Controller\Validator;

use DataBase\Controller\Controller;

class SettersValidator extends Validator
{

    /**
     *
     * @var Schema\Validation
     */
    private $_validation;

    /**
     *
     * @param Controller $_controller
     * @param Schema\Validation $_schema
     */
    public function __construct(
        Controller $_controller,
        Schema\Validation $_schema
    ) {
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
    }

    private function validData()
    {
        foreach ($this->commandArray as $column => $value) {
            $value = $this->getSetter($column);
            if (! $this->_validation->$column($value)) {
                $this->setError('valid' . ucfirst($column));
            }
        }
    }
}
