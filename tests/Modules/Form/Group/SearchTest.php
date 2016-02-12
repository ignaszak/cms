<?php
namespace Test\Modules\Form;

use Form\Group\Search;
use Test\Init\InitConf;

class SearchTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Form
     */
    private $_search;

    public function setUp()
    {
        InitConf::run();
        $this->_search = new Search($this->mockForm('search'));
    }

    public function testGetFormActionAdress()
    {
        $this->assertTrue(is_string($this->_search->getFormActionAdress()));
    }

    public function testInputSearch()
    {
        $customElemnts = array('anyElement' => 'anyValue');
        $this->assertEquals(
            '<input type="text" name="search" required class="form-control" id="search" anyElement="anyValue">',
            $this->_search->inputSearch($customElemnts)
        );
    }

    private function mockForm(string $formName): \Form\Form
    {
        $_form = $this->getMockBuilder('Form\Form')->getMock();
        $_form->method('getFormName')->willReturn($formName);
        return $_form;
    }
}
