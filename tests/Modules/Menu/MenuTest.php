<?php

namespace Test\Modules\Menu;

use Menu\Menu;
use Test\Init\InitDoctrine;
use Test\Init\InitConf;
use Test\Mock\MockTest;

class MenuTest extends \PHPUnit_Framework_TestCase
{

    private static $_menu;

    public static function setUpBeforeClass()
    {
        InitDoctrine::queryBuilderResult(array(null));
        InitDoctrine::getRepositoryResult(array(null));
        InitConf::run(); // Sets site adress as '';
        self::$_menu = new Menu;
    }

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testLoadMenuItemsArrayToProperty()
    {
        $stubMenuItems = \Mockery::mock('MenuItems');
        $stubMenuItems->shouldReceive(array(
            'getAdress',
            'getTitle'
        ));
        $stubMenu = \Mockery::mock('Menu');
        $stubMenu->shouldReceive('getMenuItems')->andReturn($stubMenuItems)->once();
        InitDoctrine::queryBuilderResult(array($stubMenu));
        MockTest::callMockMethod(self::$_menu, 'loadMenuItmsByPosition', array('head'));
    }

    public function testIfAdressIsCorrectUrl()
    {
        $anyAdressUrl = 'http://example.com';
        $adress = MockTest::callMockMethod(self::$_menu, 'validAdress', array($anyAdressUrl));
        $this->assertEquals($anyAdressUrl, $adress);
    }

    public function testIfAdressIsCMSRoute()
    {
        $anyRoute = 'post/alias';
        $adress = MockTest::callMockMethod(self::$_menu, 'validAdress', array($anyRoute));
        $this->assertEquals($anyRoute, $adress);
    }

    public function testCreateMenuFromMenuItemsArray()
    {
        $menuString = MockTest::callMockMethod(self::$_menu,
            'createMenu', array(''));
        $this->assertNotEmpty($menuString);
        $this->assertTrue(is_string($menuString));
    }

}
