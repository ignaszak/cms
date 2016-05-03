<?php
namespace Test\Model\DataBase\Controller\Validator;

use Test\Mock\MockTest;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \DataBase\Controller\Validator\Validator
     */
    private $validator;

    public function setUp()
    {
        $controller = $this->getMockBuilder('DataBase\Controller\Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->method('entity')->willReturn(
            \Mockery::mock('alias:Entity\EntityName')
        );

        $validator = $this->getMockBuilder(
            'DataBase\Controller\Validator\Validator'
        )->setConstructorArgs([$controller])->getMockForAbstractClass();
        $this->validator = $validator;
    }

    public function testConstructor()
    {
        $_controller = \PHPUnit_Framework_Assert::readAttribute(
            $this->validator,
            'controller'
        );
        $entityName = \PHPUnit_Framework_Assert::readAttribute(
            $this->validator,
            'entityName'
        );

        $this->assertInstanceOf('DataBase\Controller\Controller', $_controller);
        $this->assertEquals('Entity\EntityName', $entityName);

    }

    public function testGetSetterValue()
    {
        $_controller = \PHPUnit_Framework_Assert::readAttribute(
            $this->validator,
            'controller'
        );
        MockTest::inject($_controller, 'entitySettersArray', [
            'setTitle' => 'value of setter'
        ]);
        $setter = MockTest::callMockMethod(
            $this->validator,
            'getSetter',
            ['title']
        );
        $this->assertEquals('value of setter', $setter);
    }

    public function testGetNoExitingSetter()
    {
        $setter = MockTest::callMockMethod(
            $this->validator,
            'getSetter',
            ['noExistingSetter']
        );
        $this->assertFalse($setter);
    }

    public function testSetError()
    {
        MockTest::callMockMethod($this->validator, 'setError', ['anyError1']);
        MockTest::callMockMethod($this->validator, 'setError', ['anyError2']);
        $this->assertEquals(
            [
                'anyError1' => 1,
                'anyError2' => 1
            ],
            $this->validator->getErrors()
        );
    }
}
