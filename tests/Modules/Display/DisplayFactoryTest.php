<?php

namespace Test\Modules\Display;

use Conf\Conf;
use Test\Init\InitRouter;
use Test\Init\InitDisplay;
use Display\DisplayFactory;

class DisplayFactoryTest extends \PHPUnit_Framework_TestCase
{

    private $_displayFactory;

    public function setUp()
    {
        $this->_displayFactory = new DisplayFactory;
    }

    public function test__call()
    {
        $siteTitle = Conf::instance()->getSiteTitle();
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
