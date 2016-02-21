<?php
namespace Test\Modules\Breadcrumbs;

use Breadcrumbs\CategoryBreadcrumbs;
use Test\Init\InitDoctrine;
use Test\Mock\MockTest;
use Test\Init\InitRouter;
use Test\Init\InitConf;
use Ignaszak\Registry\RegistryFactory;

class CategoryBreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    private $_categoryBc;

    public function setUp()
    {
        $this->_categoryBc = new CategoryBreadcrumbs();
    }

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testSetBreadcrumbsArray()
    {
        $this->mockCategoryList(['anyCategory']);
        MockTest::callMockMethod($this->_categoryBc, 'setBreadcrumbsArray');
        $breadcrumbsArray = \PHPUnit_Framework_Assert::readAttribute($this->_categoryBc, 'breadcrumbsArray');
        $this->assertEquals(['anyCategory'], $breadcrumbsArray);
    }

    public function testGenerateBreadcrumbs()
    {
        $stub = new class {
        public function getId()
        {
            return 55;
        }
        public function getTitle()
        {
            return 'anyTitle';
        }
        public function getAlias()
        {
            return 'anyAlias';
        }
        public function getParentId()
        {
            return 54;
        }
        };
        MockTest::inject($this->_categoryBc, 'breadcrumbsArray', [$stub]);
        $catId = 55;
        InitConf::run(['getBaseUrl' => 'anyBaseUrl/']);
        $array = MockTest::callMockMethod($this->_categoryBc, 'generateBreadcrumbs', [$catId]);
        $this->assertEquals('anyTitle', $array[0]->title);
        $this->assertEquals('anyBaseUrl/category/anyAlias', $array[0]->link);
    }

    public function testGetCategoryIdFromCategoryRoute()
    {
        InitRouter::start('category/anyCategory');
        InitRouter::add('category', 'category/{alias:anyCategory}');
        InitRouter::run();
        $stub = new class {
        public function getId()
        {
            return 1;
        }
        };
        InitDoctrine::queryBuilderResult([$stub]);
        $catId = MockTest::callMockMethod($this->_categoryBc, 'getCategoryId');
        $this->assertEquals(1, $catId);
    }

    public function testCreateBreadcrumbsWithActiveCategory()
    {
        $this->mockCategoryList([]);
        $stub = new class {
        public function getId()
        {
            return 1;
        }
        };
        InitDoctrine::queryBuilderResult([$stub]);
        $this->assertEmpty($this->_categoryBc->createBreadcrumbs());
    }

    public function testGetCategoryIdFromPostRoute()
    {
        InitRouter::start('post/anyPost');
        InitRouter::add('post', 'post/{alias:anyPost}');
        InitRouter::run();
        $stub = new class {
        public function getCategory()
        {
            return new class {
            public function getId()
            {
                return 1;
            }
            };
        }
        };
        InitDoctrine::queryBuilderResult([$stub]);
        $catId = MockTest::callMockMethod($this->_categoryBc, 'getCategoryId');
        $this->assertEquals(1, $catId);
    }

    public function testReturnNoCategoryIdWhenAliasIsEmpty()
    {
        InitRouter::start('routeWithNoAlias');
        InitRouter::add('noAlias', 'routeWithNoAlias');
        InitRouter::run();
        $catId = MockTest::callMockMethod($this->_categoryBc, 'getCategoryId');
        $this->assertEquals(0, $catId);
    }

    public function testCreateBreadcrumbsWithNoActiveCategory()
    {
        $this->assertEquals(
            'Home',
            $this->_categoryBc->createBreadcrumbs()[0]->title
        );
    }

    private function mockCategoryList($return)
    {
        $stub = \Mockery::mock('CategoryList');
        $stub->shouldReceive('get')->andReturn($return);
        RegistryFactory::start()->set('System\Storage\CategoryList', $stub);
    }
}
