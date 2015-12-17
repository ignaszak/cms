<?php

namespace Test\Modules\FrontController;

use FrontController\CommandHandler;

class CommandHandlerTest extends \PHPUnit_Framework_TestCase
{

    private $_commandHandler;

    public function setUp()
    {
        $this->_commandHandler = new CommandHandler;
    }

    public function testConstructor()
    {
        $_base = \PHPUnit_Framework_Assert::readAttribute($this->_commandHandler, '_base');
        $_default = \PHPUnit_Framework_Assert::readAttribute($this->_commandHandler, '_default');
        $this->assertInstanceOf('ReflectionClass', $_base);
        $this->assertInstanceOf('Controller\DefaultController', $_default);
        $this->assertEquals($_base->getName(), 'FrontController\Controller');
    }

    public function testEmptyController()
    {
        $stub = $this->getMock('System\Router\Route');
        $getCommand = $this->_commandHandler->getCommand($stub);
        $this->assertFalse($getCommand);
    }

    public function testSetControllerClassInstance()
    {
        $stubRoute = $this->getMock('System\Router\Route');
        $stubRoute->expects($this->any())
            ->method('__get')
            ->will($this->returnValue('Controller\DefaultController'));
        
        $getCommand = $this->_commandHandler->getCommand($stubRoute);
        $this->assertTrue($getCommand);
    }

}
