<?php
namespace Test\Model\Menu;

use Menu\Menu;
use Test\Mock\MockQueryContent;
use Test\Mock\MockDoctrine;
use Test\Mock\MockConf;
use Test\Mock\MockTest;
use Ignaszak\Registry\RegistryFactory;

class MenuTest extends \PHPUnit_Framework_TestCase
{

    private static $_menu;

    public static function setUpBeforeClass()
    {
        $stub = \Mockery::mock('alias:MenuItems');
        $stub->shouldReceive(array(
            'getAdress',
            'getTitle',
            'getMenuItems' => $stub
        ));
        $value = MockQueryContent::getContent(array(
            $stub
        ));
        RegistryFactory::start()->set('Content\Query\Content', $value);
        MockDoctrine::queryBuilderResult(array(
            null
        ));
        MockDoctrine::getRepositoryResult(array(
            null
        ));
        MockConf::run(); // Sets site adress as '';
        self::$_menu = new Menu();
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    public function testLoadMenuItemsArrayToProperty()
    {
        MockTest::callMockMethod(self::$_menu, 'loadMenuItmsByPosition', array(
            'head'
        ));
    }

    public function testIfAdressIsCorrectUrl()
    {
        $anyAdressUrl = 'http://example.com';
        $adress = MockTest::callMockMethod(self::$_menu, 'validAdress', array(
            $anyAdressUrl
        ));
        $this->assertEquals($anyAdressUrl, $adress);
    }

    public function testIfAdressIsCMSRoute()
    {
        $anyRoute = 'post/alias';
        $adress = MockTest::callMockMethod(self::$_menu, 'validAdress', array(
            $anyRoute
        ));
        $this->assertEquals($anyRoute, $adress);
    }

    public function testCreateMenuFromMenuItemsArray()
    {
        $menuString = MockTest::callMockMethod(self::$_menu, 'createMenu', array(
            ''
        ));
        $this->assertNotEmpty($menuString);
        $this->assertTrue(is_string($menuString));
    }
}
