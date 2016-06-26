<?php

namespace Test\Model\Auth;

use Auth\Auth;
use Test\Mock\MockDoctrine;
use Test\Mock\MockTest;

class AuthTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Auth
     */
    private $auth = null;

    public function setUp()
    {
        $_SERVER['REMOTE_ADDR'] = '';
        $mock = \Mockery::mock('alias:Entity\Users');
        $mock->shouldReceive('getPassword')
            ->andReturn('$2y$10$Yzmh6Y2kXJcregPqkWc4TebCU6CI2lE0BSpL4Wq/EeZUzeTdrkglO');
        $mock->shouldReceive('getId')->andReturn(1);
        MockDoctrine::queryBuilderResult([$mock]);
        $this->auth = new Auth($this->mockCommand());
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(
            'DataBase\Command\Command',
            MockTest::property($this->auth, 'command')
        );
    }

    public function testRegister()
    {
        $mock = $this->mockCommand();
        $mock->method('__call')->willReturnSelf();
        $mock->expects($this->once())->method('insert');
        $this->auth = new Auth($mock);
        $this->auth->register();
    }

    public function testLogin()
    {
        $mock = $this->createMock('DataBase\Command\Command');
        $mock->expects($this->exactly(3))->method('__call')->willReturn('test');
        $mock->method('em')->willReturn(MockDoctrine::getEM());
        $this->auth = new Auth($mock);
        $this->auth->login();
    }

    public function testCreateToken()
    {
        $this->assertEquals(
            32,
            strlen(MockTest::callMockMethod($this->auth, 'createToken'))
        );
    }

    public function testGetUser()
    {
        $mock = $this->mockCommand();
        $mock->method('__call')->willReturn(''); // any string to mock login and email
        $this->auth = new Auth($mock);
        $this->assertInstanceOf(
            'Entity\Users',
            MockTest::callMockMethod($this->auth, 'getUser')
        );
    }

    public function testNotRemember()
    {
        $this->assertFalse(MockTest::property($this->auth, 'remember'));
    }

    public function testRemember()
    {
        $this->auth->remember();
        $this->assertTrue(MockTest::property($this->auth, 'remember'));
    }

    public function testIsUserLoggedIn()
    {
        $mock = $this->createMock('DataBase\Command\Command');
        $mock->expects($this->exactly(3))->method('__call')->willReturn('test');
        $mock->method('em')->willReturn(MockDoctrine::getEM());
        $this->auth = new Auth($mock);
        $this->auth->isUserLoggedIn();
    }

    private function mockCommand()
    {
        $mock = $this->getMockBuilder('DataBase\Command\Command')
            ->disableOriginalConstructor()
            ->getMock();

        return $mock;
    }
}
