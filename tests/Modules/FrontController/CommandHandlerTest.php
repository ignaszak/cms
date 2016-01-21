<?php
namespace Test\Modules\FrontController;

use FrontController\CommandHandler;
use Ignaszak\Registry\RegistryFactory;

class CommandHandlerTest extends \PHPUnit_Framework_TestCase
{

    private $_commandHandler;

    public function setUp()
    {
        $this->_commandHandler = new CommandHandler();
    }

    public function testConstructor()
    {
        $_base = \PHPUnit_Framework_Assert::readAttribute($this->_commandHandler, '_base');
        $this->assertInstanceOf('ReflectionClass', $_base);
        $this->assertEquals($_base->getName(), 'FrontController\Controller');
    }

    public function testLoadDefaultController()
    {
        $this->mockView();
        $stub = $this->getMock('System\Router\Route');
        $getCommand = $this->_commandHandler->getCommand($stub);
        $this->assertTrue($getCommand);
    }

    public function testSetControllerClassInstance()
    {
        $this->mockView();
        $stubRoute = $this->getMock('System\Router\Route');
        $stubRoute->expects($this->any())
            ->method('__get')
            ->will($this->returnValue('Controller\DefaultController'));
        $getCommand = $this->_commandHandler->getCommand($stubRoute);
        $this->assertTrue($getCommand);
    }

    private function mockView()
    {
        $_view = \Mockery::mock('alias:View\View');
        $_view->shouldReceive('addView');
        RegistryFactory::start()->set('view', $_view);
    }
}
