<?php
namespace Test\Model\FrontController;

use FrontController\FrontController;

class FrontControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testCallGetCommantMethod()
    {
        $this->getMock('FrontController\Controller');
        $stub = $this->getMock('FrontController\CommandHandler');
        $stub->expects($this->once())
            ->method('getCommand');
        
        FrontController::run($stub);
    }
}
