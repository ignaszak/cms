<?php
namespace Test\Modules\ViewHelper;

use Test\Init\InitRouter;
use Test\Init\InitDoctrine;
use Test\Init\InitViewHelper;
use Test\Init\InitConf;
use ViewHelper\ViewHelper;

class ViewHelperTest extends \PHPUnit_Framework_TestCase
{

    private $_viewHelper;

    public function setUp()
    {
        InitConf::run();
        $this->_viewHelper = new ViewHelper();
    }

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    /**
     * @expectedException \CMSException\InvalidClassException
     */
    public function test__callException()
    {
        $this->_viewHelper->getNonExistingMethod();
    }

    public function testDisplay()
    {
        InitViewHelper::loadExtensions();
        InitRouter::start('post', 'post');
        InitRouter::add('post', 'post');
        InitRouter::run();
        InitDoctrine::queryBuilderResult(array(
            'AnyResult'
        ));
        $this->assertNotEmpty($this->_viewHelper->display());
    }
}
