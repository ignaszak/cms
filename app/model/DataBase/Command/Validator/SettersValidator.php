<?php
namespace DataBase\Command\Validator;

use DataBase\Command\Command;

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
        Command $command,
        Schema\Validation $schema
    ) {
        parent::__construct($command);
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
