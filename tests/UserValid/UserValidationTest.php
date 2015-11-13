<?php

class UserValidationTest extends PHPUnit_Framework_TestCase
{
    private $object;
    
    public function setUp()
    {
        $this->object = new UserAuth\Validation\UserValidation;
    }
    
    public function testValidUserName()
    {
        $this->assertEquals(1, $this->object->validUserName('tomek'));
    }
}
