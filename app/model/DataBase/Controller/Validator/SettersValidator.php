<?php
namespace DataBase\Controller\Validator;

use DataBase\Controller\Controller;

class SettersValidator extends Validator
{

    /**
     *
     * @var Schema\Validation
     */
    private $validation = null;

    /**
     *
     * @param Controller $controller
     * @param Schema\Validation $schema
     */
    public function __construct(
        Controller $controller,
        Schema\Validation $schema
    ) {
        parent::__construct($controller);
        $this->validation = $schema;
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
            if (! $this->validation->$column($value)) {
                $this->setError('valid' . ucfirst($column));
            }
        }
    }
}
