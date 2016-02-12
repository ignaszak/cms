<?php
namespace Test\Modules\Form\Group;

use Test\Mock\MockTest;

class GroupTest extends \PHPUnit_Framework_TestCase
{

    private $_group;

    public function setUp()
    {
        $this->mockGroup('groupName-actionName');
    }

    public function testConstructor()
    {
        $_form = \PHPUnit_Framework_Assert::readAttribute($this->_group, '_form');
        $_conf = \PHPUnit_Framework_Assert::readAttribute($this->_group, '_conf');
        $formAction = \PHPUnit_Framework_Assert::readAttribute($this->_group, 'formAction');

        $this->assertInstanceOf('Form\Form', $_form);
        $this->assertInstanceOf('Conf\Conf', $_conf);
        $this->assertEquals('actionName', $formAction);
    }

    public function testGetFormAction()
    {
        $this->mockGroup('anyGroup-anyAction');
        $action = MockTest::callMockMethod($this->_group, 'getFormAction');
        $this->assertEquals('anyAction', $action);
    }

    public function testGetFormActionFromGroup()
    {
        $this->mockGroup('anyGroupWithoutAction');
        $action = MockTest::callMockMethod($this->_group, 'getFormAction');
        $this->assertEquals('anyGroupWithoutAction', $action);
    }

    private function mockGroup(string $formName)
    {
        $_form = $this->getMockBuilder('Form\Form')->getMock();
        $_form->method('getFormName')->willReturn($formName);
        $_group = $this->getMockBuilder('Form\Group\Group')
            ->setConstructorArgs([$_form])
            ->getMockForAbstractClass();
        $this->_group = $_group;
    }
}
