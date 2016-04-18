<?php
namespace Test\Model\Breadcrumbs;

use Breadcrumbs\CategoryBreadcrumbs;
use Test\Mock\MockDoctrine;
use Test\Mock\MockTest;
use Ignaszak\Registry\RegistryFactory;
use Test\Mock\MockHttp;

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
        $breadcrumbsArray = \PHPUnit_Framework_Assert::readAttribute(
            $this->_categoryBc, 'breadcrumbsArray'
        );
        $this->assertEquals(['anyCategory'], $breadcrumbsArray);
    }

    /*public function testGenerateBreadcrumbs()
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
    }*/

    public function testGetCategoryIdFromCategoryRoute()
    {
        MockHttp::routeGroup('category');
        MockHttp::routeSet(['alias' => 'anyCategory']);
        MockHttp::run();
        $this->_categoryBc = new CategoryBreadcrumbs();
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
        MockHttp::routeGroup('post');
        MockHttp::routeSet(['alias' => 'anyPost']);
        MockHttp::run();
        $this->_categoryBc = new CategoryBreadcrumbs();
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
        MockHttp::routeName('noAlias');
        MockHttp::run();
        $this->_categoryBc = new CategoryBreadcrumbs();
        $stub = new class {
            public function getCategory()
            {
                return new class {
                    public function getId()
                    {
                        return 0;
                    }
                    public function select()
                    {
                    }
                };
            }
        };
        MockDoctrine::queryBuilderResult([$stub]);
        $catId = MockTest::callMockMethod($this->_categoryBc, 'getCategoryId');
        $this->assertEquals(0, $catId);
    }

    public function testCreateBreadcrumbsWithNoActiveCategory()
    {
        $stub = new class {
            public function getCategory()
            {
                return new class {
                    public function getId()
                    {
                        return 0;
                    }
                };
            }
        };
        MockDoctrine::queryBuilderResult([$stub]);
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
