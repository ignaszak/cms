<?php
namespace Test\Model\View;

use View\View;

class ViewTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var View\View
     */
    private $view = null;

    public function setUp()
    {
        $this->view = new View($this->mockViewHelper());
    }

    public function testCallMethodFromAddedClass()
    {
        $class = new class () {
            public function anyMethodName()
            {
                return true;
            }
        };
        $this->view = new View($this->mockViewHelper([
            'anyMethodName' => get_class($class)
        ]));
        $this->assertTrue($this->view->anyMethodName());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCallInvalidMethod()
    {
        $this->view->anyMethodName();
    }

    private function mockViewHelper(array $methods = [])
    {
        $stub = $this->getMock('View\ViewHelper');
        $stub->method('getMethods')->willReturn($methods);
        return $stub;
    }
}
