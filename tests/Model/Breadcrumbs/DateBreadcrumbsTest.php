<?php
namespace Test\Model\Breadcrumbs;

use Breadcrumbs\DateBreadcrumbs;
use Test\Mock\MockHttp;
use Ignaszak\Registry\RegistryFactory;

class DateBreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    private $_dateBc;

    public function setUp()
    {
        MockHttp::routeSet([
            'year' => '2016',
            'month' => '02',
            'day' => '21',
            's1' => '-',
            's2' => '-'
        ]);
        MockHttp::run();
        $this->_dateBc = new DateBreadcrumbs();
    }

    public function testCreateBreadcrumbs()
    {
        $this->mockUrl();
        $array = $this->_dateBc->createBreadcrumbs();
        $this->assertEquals('2016', $array[1]->title);
        $this->assertEquals('02', $array[2]->title);
        $this->assertEquals('21', $array[3]->title);
    }

    private function mockUrl()
    {
        $stub = \Mockery::mock('UrlGenerator');
        $stub->shouldReceive('url')->andReturn('anyUrl')->once();
        RegistryFactory::start()->set('url', $stub);
    }
}
