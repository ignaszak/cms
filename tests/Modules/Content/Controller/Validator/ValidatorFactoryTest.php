<?php
namespace Test\Modules\Content\Controller\Validator;

use Test\Mock\MockTest;
use Content\Controller\Validator\ValidatorFactory;

class ValidatorFactoryTest extends \PHPUnit_Framework_TestCase
{

    private $_validatorFactory;

    public function setUp()
    {
        $controller = $this->getMockBuilder('\Content\Controller\Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $schema = $this->getMockBuilder('\Content\Controller\Validator\Schema\Validation')
            ->getMock();
        $this->_validatorFactory = new ValidatorFactory($controller, $schema);
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
                'unique',
                'eq' => ['reEmail2', 'reEmail1']
            ]
        ];

        $command = [
            'unique' => ['login', 'email'],
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
        MockTest::callMockMethod(
            $this->_validatorFactory,
            'getValidator',
            [
                ['Test\Modules\Content\Controller\Validator\Test'
                    => ['test command']]
            ]
        );
    }
}
