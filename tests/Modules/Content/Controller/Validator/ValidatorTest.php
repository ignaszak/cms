<?php
namespace Test\Modules\Content\Controller\Validator;

use Content\Controller\Validator\Validator;
use Test\Mock\MockTest;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    private $_validator;

    public function setUp()
    {
        $controller = $this->getMockBuilder('Content\Controller\Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->method('entity')->willReturn(
            \Mockery::mock('alias:Entity\EntityName')
        );

        $validator = $this->getMockBuilder('Content\Controller\Validator\Validator')
            ->setConstructorArgs(array($controller))
            ->getMockForAbstractClass();
        $this->_validator = $validator;
    }

    public function testConstructor()
    {
        $_controller = \PHPUnit_Framework_Assert::readAttribute($this->_validator, '_controller');
        $entityName = \PHPUnit_Framework_Assert::readAttribute($this->_validator, 'entityName');

        $this->assertInstanceOf('Content\Controller\Controller', $_controller);
        $this->assertEquals('Entity\EntityName', $entityName);

    }

    public function testGetSetterValue()
    {
        $_controller = \PHPUnit_Framework_Assert::readAttribute($this->_validator, '_controller');
        MockTest::inject($_controller, 'entitySettersArray', ['setTitle' => 'value of setter']);
        $setter = MockTest::callMockMethod($this->_validator, 'getSetter', ['title']);
        $this->assertEquals('value of setter', $setter);
    }

    public function testGetNoExitingSetter()
    {
        $setter = MockTest::callMockMethod($this->_validator, 'getSetter', ['noExistingSetter']);
        $this->assertFalse($setter);
    }

    public function testSetError()
    {
        MockTest::callMockMethod($this->_validator, 'setError', ['anyError1']);
        MockTest::callMockMethod($this->_validator, 'setError', ['anyError2']);
        $this->assertEquals(
            [
                'anyError1' => 1,
                'anyError2' => 1
            ],
            $this->_validator->getErrors()
        );
    }
}
