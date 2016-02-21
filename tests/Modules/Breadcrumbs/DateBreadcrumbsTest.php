<?php
namespace Test\Modules\Breadcrumbs;

use Breadcrumbs\DateBreadcrumbs;
use Test\Init\InitRouter;
use Test\Init\InitConf;

class DateBreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    private $_dateBc;

    public function setUp()
    {
        $this->_dateBc = new DateBreadcrumbs();
    }

    public function testCreateBreadcrumbs()
    {
        InitRouter::start('date/2016-02-21');
        InitRouter::add('date', 'date/{date:([0-9-]*)}');
        InitRouter::run();
        InitConf::run(['getBaseUrl' => 'anyBaseUrl/']);
        $array = $this->_dateBc->createBreadcrumbs();
        $this->assertEquals('anyBaseUrl/date/2016', $array[1]->link);
        $this->assertEquals('anyBaseUrl/date/2016-02', $array[2]->link);
        $this->assertEquals('anyBaseUrl/date/2016-02-21', $array[3]->link);
    }
}
