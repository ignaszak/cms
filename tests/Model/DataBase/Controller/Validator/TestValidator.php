<?php
namespace Test\Model\DataBase\Controller\Validator;

class TestValidator
{

    public function valid(array $command)
    {
        throw new \Exception(
            'Mock Validator with command: ' . $command[0]
        );
    }
}
