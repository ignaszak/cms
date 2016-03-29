<?php
namespace Test\Model\Breadcrumbs;

use Breadcrumbs\DateBreadcrumbs;
use Test\Mock\MockRouter;
use Test\Mock\MockConf;

class DateBreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    private $_dateBc;

    public function setUp()
    {
        $this->_dateBc = new DateBreadcrumbs();
    }

    public function testCreateBreadcrumbs()
    {
        MockRouter::start('/date/2016-02-21');
        MockRouter::add('date', '/date/{date}')->token('date', '([0-9-]+)');
        MockRouter::run();
        MockConf::run(['getBaseUrl' => 'anyBaseUrl/']);
        $array = $this->_dateBc->createBreadcrumbs();
        $this->assertEquals('anyBaseUrl/date/2016', $array[1]->link);
        $this->assertEquals('anyBaseUrl/date/2016-02', $array[2]->link);
        $this->assertEquals('anyBaseUrl/date/2016-02-21', $array[3]->link);
    }
}
