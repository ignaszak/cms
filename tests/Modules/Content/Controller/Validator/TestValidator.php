<?php
namespace Test\Modules\Content\Controller\Validator;

class TestValidator
{

    public function valid(array $command)
    {
        throw new \Exception(
            'Mock Validator with command: ' . $command[0]
        );
    }
}
