<?php
namespace Test\Model\Breadcrumbs;

use Breadcrumbs\CategoryBreadcrumbs;
use Test\Mock\MockDoctrine;
use Test\Mock\MockTest;
use Test\Mock\MockRouter;
use Ignaszak\Registry\RegistryFactory;
use Ignaszak\Router\Link;

class CategoryBreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    private $_categoryBc;

    public function setUp()
    {
        $this->_categoryBc = new CategoryBreadcrumbs();
    }

    public function tearDown()
    {
        MockDoctrine::clear();
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
        $stub = $this->getMockBuilder('Ignaszak\Router\Link')
            ->disableOriginalConstructor()->getMock();
        $stub->method('getLink')->willReturn('category/anyAlias');
        MockTest::injectStatic(Link::instance(), 'link', $stub);
        $array = MockTest::callMockMethod(
            $this->_categoryBc, 'generateBreadcrumbs', [$catId]
        );
        $this->assertEquals('anyTitle', $array[0]->title);
        $this->assertEquals('category/anyAlias', $array[0]->link);
    }

    public function testGetCategoryIdFromCategoryRoute()
    {
        MockRouter::start('/category/anyCategory');
        MockRouter::group('category');
        MockRouter::add('category', '/category/{alias}')->token('alias', 'anyCategory');
        MockRouter::run();
        $stub = new class {
        public function getId()
        {
            return 1;
        }
        };
        MockDoctrine::queryBuilderResult([$stub]);
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
        MockDoctrine::queryBuilderResult([$stub]);
        $this->assertEmpty($this->_categoryBc->createBreadcrumbs());
    }

    public function testGetCategoryIdFromPostRoute()
    {
        MockRouter::start('post/anyPost');
        MockRouter::group('post');
        MockRouter::add('post', 'post/{alias}')->token('alias', 'anyPost');
        MockRouter::run();
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
        MockDoctrine::queryBuilderResult([$stub]);
        $catId = MockTest::callMockMethod($this->_categoryBc, 'getCategoryId');
        $this->assertEquals(1, $catId);
    }

    public function testReturnNoCategoryIdWhenAliasIsEmpty()
    {
        MockRouter::start('routeWithNoAlias');
        MockRouter::add('noAlias', 'routeWithNoAlias');
        MockRouter::run();
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
        RegistryFactory::start()->set('App\Resource\CategoryList', $stub);
    }
}
