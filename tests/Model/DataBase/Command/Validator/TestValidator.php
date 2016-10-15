<?php
namespace Test\Model\DataBase\Command\Validator;

class TestValidator
{

    public function valid(array $command)
    {
        throw new \Exception(
            'Mock Validator with command: ' . $command[0]
        );
    }
}
