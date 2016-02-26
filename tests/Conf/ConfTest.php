<?php
namespace Test\Conf;

use Conf\Conf;

class ConfTest extends \PHPUnit_Framework_TestCase
{

    private $_conf;

    public function setUp()
    {
        $this->_conf = new Conf();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testThrowExceptionWhenSettersIsCalled()
    {
        $this->_conf->setSiteTitle();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testThrowExceptionIdMethodIsCalled()
    {
        $this->_conf->id();
    }

    public function testCallGetter()
    {
        $this->assertNotNull($this->_conf->getSiteTitle());
    }
}
