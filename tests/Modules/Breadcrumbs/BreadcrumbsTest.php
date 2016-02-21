<?php
namespace Test\Modules\Breadcrumbs;

use Breadcrumbs\Breadcrumbs;
use Test\Init\InitRouter;
use Test\Mock\MockTest;

class BreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    private $_bc;

    public function setUp()
    {
        $this->_bc = new Breadcrumbs();
    }

    public function testCreateBreadcrumbs()
    {
        $this->assertEmpty($this->_bc->createBreadcrumbs());
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
            $this->_bc,
            'addActiveClass',
            [$breadcrumbs]
        );
        $this->assertEquals('active', $addActiveClass[1]->active);
        $this->assertEquals('', $addActiveClass[1]->link);
    }

    private function getBreadcrumbs(string $routeName, string $className)
    {
        InitRouter::start($routeName);
        InitRouter::add($routeName, $routeName);
        InitRouter::run();
        $this->_bc->getBreadcrumbs();
        $bc = \PHPUnit_Framework_Assert::readAttribute($this->_bc, '_breadcrumbs');
        $this->assertInstanceOf($className, $bc);
    }
}
