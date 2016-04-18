<?php
namespace Test\Model\ViewHelper;

use Test\Mock\MockDoctrine;
use Test\Mock\MockViewHelper;
use Test\Mock\MockConf;
use ViewHelper\ViewHelper;
use Test\Mock\MockHttp;

class ViewHelperTest extends \PHPUnit_Framework_TestCase
{

    private $_viewHelper;

    public function setUp()
    {
        MockConf::run();
        $this->_viewHelper = new ViewHelper();
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function test__callException()
    {
        $this->_viewHelper->getNonExistingMethod();
    }

    public function testDisplay()
    {
        MockViewHelper::loadExtensions();
        MockHttp::routeGroup('post');
        MockHttp::run();
        $this->_viewHelper = new ViewHelper();
        MockDoctrine::queryBuilderResult(['AnyResult']);
        $this->assertNotEmpty($this->_viewHelper->display());
    }
}
