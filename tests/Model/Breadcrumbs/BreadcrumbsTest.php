<?php
namespace Test\Model\Breadcrumbs;

use Breadcrumbs\Breadcrumbs;
use Test\Mock\MockTest;
use Test\Mock\MockHttp;
use Ignaszak\Registry\RegistryFactory;

class BreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Breadcrumbs\Breadcrumbs
     */
    private $bc;

    public function setUp()
    {
        $stub = \Mockery::mock('UrlGenerator');
        $stub->shouldReceive(['url' => '']);
        RegistryFactory::start()->set('url', $stub);
        $this->bc = new Breadcrumbs();
    }

    public function testCreateBreadcrumbs()
    {
        $this->assertEmpty($this->bc->createBreadcrumbs());
    }

    public function testGetCategoryBreadcrumbs()
    {
        $this->getBreadcrumbs('post', 'Breadcrumbs\CategoryBreadcrumbs');
        $this->getBreadcrumbs('category', 'Breadcrumbs\CategoryBreadcrumbs');
    }

    public function testGetDateBreadcrumbs()
    {
        $this->getBreadcrumbs('date', 'Breadcrumbs\DateBreadcrumbs');
    }

    public function testGetSearchBreadcrumbs()
    {
        $this->getBreadcrumbs('search', 'Breadcrumbs\SearchBreadcrumbs');
    }

    public function testAddActiveClass()
    {
        $object = new \stdClass();
        $object->link = 'anyLink';
        $breadcrumbs = [
            '',
            $object
        ];
        $addActiveClass = MockTest::callMockMethod(
            $this->bc,
            'addActiveClass',
            [$breadcrumbs]
        );
        $this->assertEquals('active', $addActiveClass[1]->active);
        $this->assertEquals('', $addActiveClass[1]->link);
    }

    private function getBreadcrumbs(string $routeName, string $className)
    {
        MockHttp::routeGroup($routeName);
        MockHttp::routeName($routeName);
        MockHttp::run();
        $this->bc = new Breadcrumbs();
        $this->bc->getBreadcrumbs();
        $bc = \PHPUnit_Framework_Assert::readAttribute($this->bc, 'breadcrumbs');
        $this->assertInstanceOf($className, $bc);
    }
}
