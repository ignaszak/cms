<?php
namespace Test\Modules\View;

use View\Conf;
use Test\Init\InitRouter;

class ConfTest extends \PHPUnit_Framework_TestCase
{

    private $_viewConf;

    public function setUp()
    {
        $this->_viewConf = new Conf();
    }

    public function testAdminThemePath()
    {
        InitRouter::start('admin');
        InitRouter::add('admin', 'admin');
        InitRouter::run();
        $this->_viewConf->configureThemePath();
        $this->assertContains('admin', $this->_viewConf->getThemePath());
    }

    public function UserThemePath()
    {
        InitRouter::start('post');
        InitRouter::add('post', 'post');
        InitRouter::run();
        $this->_viewConf->configureThemePath();
        $this->assertNotContains('admin', $this->_viewConf->getThemePath());
    }
}
