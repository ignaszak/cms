<?php
namespace Test\Model\Breadcrumbs;

use Test\Mock\MockTest;
use Test\Mock\MockConf;

class IBreadcrumbsTest extends \PHPUnit_Framework_TestCase
{
    private $_ibc;

    public function setUp()
    {
        MockConf::run(['getBaseUrl' => 'anyBaseUrl/']);
        $this->_ibc = $this->getMockForAbstractClass('Breadcrumbs\IBreadcrumbs');
    }

    public function testConstructor()
    {
        $_conf = \PHPUnit_Framework_Assert::readAttribute($this->_ibc, '_conf');
        $_query = \PHPUnit_Framework_Assert::readAttribute($this->_ibc, '_query');
        $this->assertInstanceOf('Conf\Conf', $_conf);
        $this->assertInstanceOf('DataBase\Query\Query', $_query);
    }

    public function testGetHome()
    {
        $getHome = MockTest::callMockMethod($this->_ibc, 'getHome');
        $this->assertEquals('Home', $getHome[0]->title);
        $this->assertEquals('anyBaseUrl/', $getHome[0]->link);
    }

    public function testAddBreadcrumb()
    {
        $arg = [
            'anyTitle',
            'AnyLink'
        ];
        $addBreadcrumb = MockTest::callMockMethod(
            $this->_ibc,
            'addBreadcrumb',
            $arg
        );
        $this->assertInstanceOf('stdClass', $addBreadcrumb);
        $this->assertEquals('anyTitle', $addBreadcrumb->title);
        $this->assertEquals('anyBaseUrl/AnyLink', $addBreadcrumb->link);
        $this->assertEquals('', $addBreadcrumb->active);
    }
}
