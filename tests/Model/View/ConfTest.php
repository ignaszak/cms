<?php
namespace Test\Model\View;

use View\Conf;
use Test\Mock\MockRouter;

class ConfTest extends \PHPUnit_Framework_TestCase
{

    private $_viewConf;

    public function setUp()
    {
        $this->_viewConf = new Conf();
    }

    public function testAdminThemePath()
    {
        MockRouter::start('admin');
        MockRouter::group('admin');
        MockRouter::add('admin', 'admin');
        MockRouter::run();
        $this->_viewConf->configureThemePath();
        $this->assertContains('admin', $this->_viewConf->getThemePath());
    }

    public function UserThemePath()
    {
        MockRouter::start('post');
        MockRouter::add('post', 'post');
        MockRouter::run();
        $this->_viewConf->configureThemePath();
        $this->assertNotContains('admin', $this->_viewConf->getThemePath());
    }
}
