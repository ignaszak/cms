<?php
namespace Test\Model\Menu;

use Menu\Menu;
use Test\Mock\MockDoctrine;
use Test\Mock\MockConf;
use Test\Mock\MockTest;
use Ignaszak\Registry\RegistryFactory;
use Test\Mock\MockQuery;

class MenuTest extends \PHPUnit_Framework_TestCase
{

    private static $_menu;

    public static function setUpBeforeClass()
    {
        $stub = \Mockery::mock('alias:MenuItems');
        $stub->shouldReceive([
            'getAdress',
            'getTitle',
            'getMenuItems' => $stub
        ]);
        $value = MockQuery::getQuery([$stub]);
        RegistryFactory::start()->set('DataBase\Query\Query', $value);
        MockDoctrine::queryBuilderResult([null]);
        MockDoctrine::getRepositoryResult([null]);
        MockConf::run(); // Sets site adress as '';
        self::$_menu = new Menu();
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    public function testLoadMenuItemsArrayToProperty()
    {
        MockTest::callMockMethod(
            self::$_menu, 'loadMenuItmsByPosition',
            ['head']
        );
    }

    public function testIfAdressIsCorrectUrl()
    {
        $anyAdressUrl = 'http://example.com';
        $adress = MockTest::callMockMethod(
            self::$_menu, 'validAdress',
            [$anyAdressUrl]
        );
        $this->assertEquals($anyAdressUrl, $adress);
    }

    public function testIfAdressIsCMSRoute()
    {
        $anyRoute = 'post/alias';
        $adress = MockTest::callMockMethod(
            self::$_menu, 'validAdress',
            [$anyRoute]
        );
        $this->assertEquals($anyRoute, $adress);
    }

    public function testCreateMenuFromMenuItemsArray()
    {
        $menuString = MockTest::callMockMethod(
            self::$_menu,
            'createMenu',
            ['']
        );
        $this->assertNotEmpty($menuString);
        $this->assertTrue(is_string($menuString));
    }
}
