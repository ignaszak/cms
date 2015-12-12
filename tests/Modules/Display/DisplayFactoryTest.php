<?php

namespace Test\Modules\Display;

use Test\Init\InitRouter;
use Test\Init\InitDisplay;
use Display\DisplayFactory;
use Ignaszak\Registry\RegistryFactory;

class DisplayFactoryTest extends \PHPUnit_Framework_TestCase
{

    private $_displayFactory;

    public function setUp()
    {
        $this->_displayFactory = new DisplayFactory;
    }

    public function test__call()
    {
        $siteTitle = RegistryFactory::start('file')->register('Conf\Conf')
            ->getSiteTitle();
        \Conf\DB\DBDoctrine::em()->clear();
        $getSiteTitle = $this->_displayFactory->getSiteTitle();
        $this->assertEquals($siteTitle, $getSiteTitle);
    }

    /**
     * @expectedException \CMSException\InvalidClassException
     */
    public function test__callException()
    {
        $this->_displayFactory->getNonExistingMethod();
    }

    public function testDisplay()
    {
        InitDisplay::loadExtensions();
        InitRouter::start('post', 'post');
        InitRouter::add('post', 'post');
        InitRouter::run();
        $this->assertNotEmpty($this->_displayFactory->display());
    }

}
