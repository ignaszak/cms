<?php
namespace Test\Model\Breadcrumbs;

use Breadcrumbs\DateBreadcrumbs;
use Test\Mock\MockRouter;

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
        MockRouter::add('date', '/date/{year}{s1}{month}{s2}{day}')->tokens([
            'year' => '(\d{4})?',
            'month' => '(\d{2})?',
            'day' => '(\d{2})?',
            's1' => '(-)?',
            's2' => '(-)?'
        ]);
        MockRouter::run();
        $array = $this->_dateBc->createBreadcrumbs();
        $this->assertEquals('2016', $array[1]->title);
        $this->assertEquals('02', $array[2]->title);
        $this->assertEquals('21', $array[3]->title);
    }
}
