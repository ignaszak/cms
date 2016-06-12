<?php
namespace Test\Model\DataBase\Command\Validator;

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
        $command = $this->getMockBuilder('DataBase\Command\Command')
            ->disableOriginalConstructor()
            ->getMock();
        $command->method('entity')->willReturn(
            \Mockery::mock('alias:Entity\EntityName')
        );

        $validator = $this->getMockBuilder(
            'DataBase\Command\Validator\Validator'
        )->setConstructorArgs([$command])->getMockForAbstractClass();
        $this->validator = $validator;
    }

    public function testConstructor()
    {
        $command = \PHPUnit_Framework_Assert::readAttribute(
            $this->validator,
            'command'
        );
        $entityName = \PHPUnit_Framework_Assert::readAttribute(
            $this->validator,
            'entityName'
        );

        $this->assertInstanceOf('DataBase\Command\Command', $command);
        $this->assertEquals('Entity\EntityName', $entityName);

    }

    public function testGetSetterValue()
    {
        $command = \PHPUnit_Framework_Assert::readAttribute(
            $this->validator,
            'command'
        );
        MockTest::inject($command, 'entitySettersArray', [
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
