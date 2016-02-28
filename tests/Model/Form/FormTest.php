<?php
namespace Test\Model\Form;

use Form\Form;
use Test\Mock\MockTest;

class FormTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Form
     */
    private $_form;

    public function setUp()
    {
        $this->_form = new Form();
    }

    public function testGetRefererDataArray()
    {
        $referData = array(
            1,
            2,
            3,
            4,
            5
        );
        MockTest::injectStatic('App\Resource\Server', 'readReferDataArray', $referData);
        $this->assertEquals($referData, $this->_form->getFormResponseData());
    }

    public function testGetSingleRefererDataByKey()
    {
        $referData = array(
            5,
            4,
            3,
            2,
            1
        );
        MockTest::injectStatic('App\Resource\Server', 'readReferDataArray', $referData);
        $this->assertEquals(4, $this->_form->getFormResponseData(1));
    }

    public function testCreateForm()
    {
        // format group-action, group chooses class
        $instance = $this->_form->createForm('user-anyAction');
        $this->assertInstanceOf('Form\Group\User', $instance);
    }

    public function testGetFormGroup()
    {
        $this->_form->createForm('user-action');
        $group = MockTest::callMockMethod($this->_form, 'getFormGroup');
        $this->assertEquals('user', $group);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetFormGroupWithNoExistingGroupForm()
    {
        $this->_form->createForm('noExistingGroup-action');
        MockTest::callMockMethod($this->_form, 'getFormGroup');
    }
}
