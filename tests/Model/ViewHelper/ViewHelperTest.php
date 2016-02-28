<?php
namespace Test\Model\ViewHelper;

use Test\Mock\MockRouter;
use Test\Mock\MockDoctrine;
use Test\Mock\MockViewHelper;
use Test\Mock\MockConf;
use ViewHelper\ViewHelper;

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
        MockRouter::start('post', 'post');
        MockRouter::add('post', 'post');
        MockRouter::run();
        MockDoctrine::queryBuilderResult(array(
            'AnyResult'
        ));
        $this->assertNotEmpty($this->_viewHelper->display());
    }
}
