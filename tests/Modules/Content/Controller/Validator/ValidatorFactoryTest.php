<?php
namespace Test\Modules\Content\Controller\Validator;

use Test\Mock\MockTest;
use Test\Init\InitSystem;
use Content\Controller\Validator\ValidatorFactory;

class ValidatorFactoryTest extends \PHPUnit_Framework_TestCase
{

    private $_validatorFactory;

    private $_controller;

    public function setUp()
    {
        $this->_controller = $this->getMockBuilder('\Content\Controller\Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $schema = $this->getMockBuilder('\Content\Controller\Validator\Schema\Validation')
            ->getMock();
        $this->_validatorFactory = new ValidatorFactory($this->_controller, $schema);
    }

    public function testValidSetters()
    {
        $stub = \Mockery::mock('SettersValidator');
        $stub->shouldReceive('valid')->once();
        MockTest::inject($this->_validatorFactory, '_settersValidator', $stub);
        $this->_validatorFactory->valid(['anyCommand']);
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
            $this->_validatorFactory,
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
            $this->_validatorFactory,
            'runValidator',
            [
                ['Test\Modules\Content\Controller\Validator\Test'
                    => ['test command']]
            ]
        );
    }

    public function testDontSendErrors()
    {
        MockTest::inject($this->_validatorFactory, 'errorArray', []);
        MockTest::callMockMethod($this->_validatorFactory, 'sendErrorsIfExists');
        $this->assertEmpty(InitSystem::getReferData());
    }

    public function testSendErrors()
    {
        $error = ['anyErrorKey' => 1];
        MockTest::inject($this->_validatorFactory, 'errorArray', $error);
        MockTest::callMockMethod($this->_validatorFactory, 'sendErrorsIfExists');
        $this->assertNotEmpty(InitSystem::getReferData());
    }

    public function testReplaceReferenceEntityToId()
    {
        $error = ['anyErrorKey' => 1];
        MockTest::inject($this->_validatorFactory, 'errorArray', $error);
        $stub = $this->getMockBuilder('Entity\Posts')->getMock();
        $stub->method('getId')->willReturn(5);
        $controller = \Mockery::mock('Controller');
        $controller->entitySettersArray = ['reference' => $stub];
        MockTest::inject($this->_validatorFactory, '_controller', $controller);
        MockTest::callMockMethod($this->_validatorFactory, 'sendErrorsIfExists');

        $this->assertEquals(
            5,
            InitSystem::getReferData()['data']['reference']
        );
    }
}
