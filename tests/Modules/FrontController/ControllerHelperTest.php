<?php
namespace Test\Modules\FrontController;

use FrontController\ControllerHelper;

class ControllerHelperTest extends \PHPUnit_Framework_TestCase
{

    private $_controllerHelper;

    public function setUp()
    {
        $stub = $this->getMockBuilder('FrontController\Controller')
            ->setMethods([
            'setViewHelper',
            'run'
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $stub->method('setViewHelper')->willReturn($this->getMock('ViewHelperController'));
        $this->_controllerHelper = new ControllerHelper($stub);
    }

    public function testSetsViewHelperMethod()
    {
        $this->_controllerHelper->setViewHelperName('AnyViewHelperControllerName');
        $this->assertTrue($this->_controllerHelper->loadViewHelperSetter());
    }
}
