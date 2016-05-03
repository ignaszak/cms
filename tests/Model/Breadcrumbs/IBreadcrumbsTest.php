<?php
namespace Test\Model\Breadcrumbs;

use Test\Mock\MockTest;
use Test\Mock\MockConf;

class IBreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Breadcrumbs\IBreadcrumbs
     */
    private $ibc;

    public function setUp()
    {
        MockConf::run(['getBaseUrl' => 'anyBaseUrl/']);
        $this->ibc = $this->getMockForAbstractClass('Breadcrumbs\IBreadcrumbs');
    }

    public function testConstructor()
    {
        $_conf = \PHPUnit_Framework_Assert::readAttribute($this->ibc, 'conf');
        $_query = \PHPUnit_Framework_Assert::readAttribute($this->ibc, 'query');
        $this->assertInstanceOf('Conf\Conf', $_conf);
        $this->assertInstanceOf('DataBase\Query\Query', $_query);
    }

    public function testGetHome()
    {
        $getHome = MockTest::callMockMethod($this->ibc, 'getHome');
        $this->assertEquals('Home', $getHome[0]->title);
    }

    public function testAddBreadcrumb()
    {
        $arg = [
            'anyTitle',
            'AnyLink'
        ];
        $addBreadcrumb = MockTest::callMockMethod(
            $this->ibc,
            'addBreadcrumb',
            $arg
        );
        $this->assertInstanceOf('stdClass', $addBreadcrumb);
        $this->assertEquals('anyTitle', $addBreadcrumb->title);
        $this->assertEquals('AnyLink', $addBreadcrumb->link);
        $this->assertEquals('', $addBreadcrumb->active);
    }
}
