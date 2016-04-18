<?php
namespace Test\Model\View;

use View\Conf;
use Test\Mock\MockHttp;

class ConfTest extends \PHPUnit_Framework_TestCase
{

    private $_viewConf;

    public function setUp()
    {
        $this->_viewConf = new Conf();
    }

    public function testAdminThemePath()
    {
        MockHttp::routeGroup('admin');
        MockHttp::run();
        $this->_viewConf = new Conf();
        $this->_viewConf->configureThemePath();
        $this->assertContains('admin', $this->_viewConf->getThemePath());
    }

    public function UserThemePath()
    {
        $this->_viewConf->configureThemePath();
        $this->assertNotContains('admin', $this->_viewConf->getThemePath());
    }
}
