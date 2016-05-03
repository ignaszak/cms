<?php
namespace Test\Model\DataBase\Controller\Validator;

use Test\Mock\MockTest;
use Test\Mock\MockSystem;
use DataBase\Controller\Validator\ValidatorFactory;

class ValidatorFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \DataBase\Controller\Validator\ValidatorFactory
     */
    private $validatorFactory;

    /**
     *
     * @var \DataBase\Controller\Controller
     */
    private $controller;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(
            '\DataBase\Controller\Controller'
        )->disableOriginalConstructor()->getMock();
        $schema = $this->getMockBuilder(
            '\DataBase\Controller\Validator\Schema\Validation'
        )->getMock();
        $this->validatorFactory = new ValidatorFactory(
            $this->controller,
            $schema
        );
    }

    public function testValidSetters()
    {
        $stub = \Mockery::mock('SettersValidator');
        $stub->shouldReceive('valid')->once();
        $stub->shouldReceive('getErrors')->andReturn([])->once();
        MockTest::inject($this->validatorFactory, 'settersValidator', $stub);
        $this->validatorFactory->valid(['anyCommand']);
    }

    public function testTransformCommandArraybySetCommand()
    {
        $input = [
            'title',
            'login' => ['unique'],
            'password' => [
                'eq' => ['rePassword2', 'rePassword1']
            ],
            'email' => [
                'unique' => ['my@email.com'],
                'eq' => ['reEmail2', 'reEmail1']
            ],
        ];

        $command = [
            'unique' => [
                'login',
                'email' => ['my@email.com']
            ],
            'eq' => [
                'password' => ['rePassword2', 'rePassword1'],
                'email' => ['reEmail2', 'reEmail1']
            ]
        ];

        $transformCommand = MockTest::callMockMethod(
            $this->validatorFactory,
            'transformCommand',
            [$input]
        );
        $this->assertEquals(
            $command,
            $transformCommand
        );
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Mock Validator with command: test command
     */
    public function testGetValidator()
    {
        define('TEST', true);
        MockTest::callMockMethod(
            $this->validatorFactory,
            'runValidator',
            [
                ['Test\Model\DataBase\Controller\Validator\Test'
                    => ['test command']]
            ]
        );
    }

    public function testDontSendErrors()
    {
        MockTest::inject($this->validatorFactory, 'errorArray', []);
        MockTest::callMockMethod($this->validatorFactory, 'sendErrorsIfExists');
        $this->assertEmpty(MockSystem::getReferData());
    }

    public function testSendErrors()
    {
        $error = ['anyErrorKey' => 1];
        MockTest::inject($this->validatorFactory, 'errorArray', $error);
        MockTest::callMockMethod($this->validatorFactory, 'sendErrorsIfExists');
        $this->assertNotEmpty(MockSystem::getReferData());
    }

    public function testReplaceReferenceEntityToId()
    {
        $error = ['anyErrorKey' => 1];
        MockTest::inject($this->validatorFactory, 'errorArray', $error);
        $stub = $this->getMockBuilder('Entity\Posts')->getMock();
        $stub->method('getId')->willReturn(5);
        $controller = \Mockery::mock('Controller');
        $controller->entitySettersArray = ['reference' => $stub];
        MockTest::inject($this->validatorFactory, 'controller', $controller);
        MockTest::callMockMethod($this->validatorFactory, 'sendErrorsIfExists');

        $this->assertEquals(
            5,
            MockSystem::getReferData()['data']['reference']
        );
    }

    public function testAddErrorsArray()
    {
        MockTest::inject($this->validatorFactory, 'errorArray', ['anyKey' => 'initState']);
        $errors = ['anyKey2' => 'anyErrors'];
        MockTest::callMockMethod($this->validatorFactory, 'addErrors', [$errors]);
        $this->assertEquals(
            \PHPUnit_Framework_Assert::readAttribute($this->validatorFactory, 'errorArray'),
            [
                'anyKey' => 'initState',
                'anyKey2' => 'anyErrors'
            ]
        );
    }
}
