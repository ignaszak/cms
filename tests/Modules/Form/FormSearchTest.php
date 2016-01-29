<?php
namespace Test\Modules\Form;

use Form\FormSearch;
use Test\Init\InitConf;
use Test\Mock\MockTest;

class FormSearchTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Form
     */
    private $_formSearch;

    public function setUp()
    {
        InitConf::run();
        $this->_formSearch = new FormSearch('search');
    }

    public function testGetFormActionAdress()
    {
        $this->assertTrue(is_string($this->_formSearch->getFormActionAdress()));
    }

    public function testInputSearch()
    {
        $customElemnts = array('anyElement' => 'anyValue');
        $this->assertEquals(
            '<input type="text" name="search" required class="form-control" id="search" anyElement="anyValue">',
            $this->_formSearch->inputSearch($customElemnts)
        );
    }
}
