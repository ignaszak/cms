<?php
namespace Test\Model\Form;

use Form\Group\User;
use Test\Mock\MockConf;
use Test\Mock\MockTest;

class UserTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Form\Group\User
     */
    private $user;

    public function setUp()
    {
        MockConf::run();
        $this->user = new User($this->mockForm('registration'));
    }

    public function tearDown()
    {
        $this->referData();
    }

    public function testGetFormActionAdress()
    {
        $stub = \Mockery::mock('UrlGenerator');
        $stub->shouldReceive('url')->andReturn('')->once();
        MockTest::inject($this->user, 'url', $stub);
        $this->user->getFormActionAdress();
    }

    public function testGetEmptyFormMessage()
    {
        $this->assertEmpty($this->user->getFormMessage());
    }

    public function testGetInputLogin()
    {
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin" minlength="2" value="">', $this->user->inputLogin());
    }

    public function testGetInputLoginWithReferLoginData()
    {
        $refer = [
            'data' => [
                'setLogin' => 'AnyLogin'
            ]
        ];
        $this->referData($refer);
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin" minlength="2" value="AnyLogin">', $this->user->inputLogin());
    }

    public function testGetInputLoginWithInccorectLogin()
    {
        $refer = [
            'error' => [
                'validLogin' => 1
            ],
            'data' => [
                'setLogin' => 'AnyLogin'
            ]
        ];
        $this->referData($refer);
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin" minlength="2">', $this->user->inputLogin());
    }

    public function testGetInputEmailWithReferEmailData()
    {
        $refer = [
            'data' => [
                'setEmail' => 'any@email.com'
            ]
        ];
        $this->referData($refer);
        $this->assertEquals('<input type="email" name="userEmail" required class="form-control" id="userEmail" value="any@email.com">', $this->user->inputEmail());
    }

    public function testGetInputEmailWithInccorectEmail()
    {
        $refer = [
            'error' => [
                'validEmail' => 1
            ],
            'data' => [
                'setEmail' => 'any@email.com'
            ]
        ];
        $this->referData($refer);
        $this->assertEquals('<input type="email" name="userEmail" required class="form-control" id="userEmail">', $this->user->inputEmail());
    }

    public function testAddAccountValue()
    {
        $stub = \Mockery::mock('ViewHelper\User');
        $stub->shouldReceive('getUserSession')->andReturnSelf()->once();
        $stub->shouldReceive('getLogin')->once();
        $stub->shouldReceive('getEmail')->once();
        $this->user = new User($this->mockForm('accountData'));
        MockTest::inject($this->user, 'user', $stub);
        MockTest::callMockMethod(
            $this->user,
            'addAccountValue',
            ['userLogin']
        );
        MockTest::callMockMethod(
            $this->user,
            'addAccountValue',
            ['userEmail']
        );
    }

    public function testGetLoginEntityGetter()
    {
        $this->assertEquals(
            'getLogin',
            MockTest::callMockMethod(
                $this->user,
                'getEntityGetter',
                ['userLogin']
            )
        );
    }

    public function testGetEmailEntityGetter()
    {
        $this->assertEquals(
            'getEmail',
            MockTest::callMockMethod(
                $this->user,
                'getEntityGetter',
                ['userEmail']
            )
        );
    }

    private function mockForm(string $formName): \Form\Form
    {
        $_form = $this->getMockBuilder('Form\Form')->getMock();
        $_form->method('getFormName')->willReturn($formName);
        return $_form;
    }

    private function referData(array $data = null)
    {
        MockTest::injectStatic(
            'App\Resource\Server',
            'readReferDataArray',
            $data
        );
    }
}
