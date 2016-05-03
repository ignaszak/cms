<?php
namespace Test\Model\Form\Group;

use Test\Mock\MockTest;

class GroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Form\Group\Group
     */
    private $group;

    public function setUp()
    {
        $this->mockGroup('groupName-actionName');
    }

    public function testConstructor()
    {
        $form = \PHPUnit_Framework_Assert::readAttribute($this->group, 'form');
        $conf = \PHPUnit_Framework_Assert::readAttribute($this->group, 'conf');
        $formAction = \PHPUnit_Framework_Assert::readAttribute($this->group, 'formAction');

        $this->assertInstanceOf('Form\Form', $form);
        $this->assertInstanceOf('Conf\Conf', $conf);
        $this->assertEquals('actionName', $formAction);
    }

    public function testGetFormAction()
    {
        $this->mockGroup('anyGroup-anyAction');
        $action = MockTest::callMockMethod($this->group, 'getFormAction');
        $this->assertEquals('anyAction', $action);
    }

    public function testGetFormActionFromGroup()
    {
        $this->mockGroup('anyGroupWithoutAction');
        $action = MockTest::callMockMethod($this->group, 'getFormAction');
        $this->assertEquals('anyGroupWithoutAction', $action);
    }

    private function mockGroup(string $formName)
    {
        $form = $this->getMockBuilder('Form\Form')->getMock();
        $form->method('getFormName')->willReturn($formName);
        $group = $this->getMockBuilder('Form\Group\Group')
            ->setConstructorArgs([$form])
            ->getMockForAbstractClass();
        $this->group = $group;
    }
}
