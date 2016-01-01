<?php

namespace Test\Modules\ViewHelper;

use Test\Init\InitRouter;
use Test\Init\InitDoctrine;
use Test\Init\InitViewHelper;
use ViewHelper\ViewHelper;
use Ignaszak\Registry\RegistryFactory;

class ViewHelperTest extends \PHPUnit_Framework_TestCase
{

    private $_viewHelper;

    public function setUp()
    {
        $this->_viewHelper = new ViewHelper;
    }

    public function tearDown()
    {
        \Mockery::close();
        InitDoctrine::clear();
    }

    public function test__call()
    {
        $siteTitle = RegistryFactory::start('file')->register('Conf\Conf')
            ->getSiteTitle();
        \Conf\DB\DBDoctrine::em()->clear();
        $getSiteTitle = $this->_viewHelper->getSiteTitle();
        $this->assertEquals($siteTitle, $getSiteTitle);
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
        InitDoctrine::queryBuilderResult(array('AnyResult'));
        $this->assertNotEmpty($this->_viewHelper->display());
    }

}
