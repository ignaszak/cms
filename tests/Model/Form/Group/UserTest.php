<?php
namespace Test\Model\Form;

use Form\Group\User;
use Test\Mock\MockConf;
use Test\Mock\MockTest;

class UserTest extends \PHPUnit_Framework_TestCase
{

    private $_user;

    public function setUp()
    {
        MockConf::run();
        $this->_user = new User($this->mockForm('registration'));
    }

    public function tearDown()
    {
        $this->referData();
    }

    public function testGetFormActionRegistrationAdress()
    {
        $this->_user = new User($this->mockForm('registration'));
        $adress = $this->_user->getFormActionAdress();
        $this->assertEquals('user/post/registration', $adress);
    }

    public function testGetFormActionLoginAdress()
    {
        $this->_user = new User($this->mockForm('login'));
        $adress = $this->_user->getFormActionAdress();
        $this->assertEquals('user/post/login', $adress);
    }

    public function testGetFormActionLogoutAdress()
    {
        $this->_user = new User($this->mockForm('logout'));
        $adress = $this->_user->getFormActionAdress();
        $this->assertEquals('user/post/logout', $adress);
    }

    public function testGetFormActionRemindAdress()
    {
        $this->_user = new User($this->mockForm('remind'));
        $adress = $this->_user->getFormActionAdress();
        $this->assertEquals('user/post/remind', $adress);
    }

    public function testGetFormActionAccountAdress()
    {
        $this->_user = new User($this->mockForm('accountData'));
        $adress = $this->_user->getFormActionAdress();
        $this->assertEquals('user/post/account', $adress);

        $this->_user = new User($this->mockForm('accountPassword'));
        $adress = $this->_user->getFormActionAdress();
        $this->assertEquals('user/post/account', $adress);
    }

    public function testGetEmptyFormMessage()
    {
        $this->assertEmpty($this->_user->getFormMessage());
    }

    public function testGetInputLogin()
    {
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin" minlength="2" value="">', $this->_user->inputLogin());
    }

    public function testGetInputLoginWithReferLoginData()
    {
        $refer = array(
            'data' => array(
                'setLogin' => 'AnyLogin'
            )
        );
        $this->referData($refer);
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin" minlength="2" value="AnyLogin">', $this->_user->inputLogin());
    }

    public function testGetInputLoginWithInccorectLogin()
    {
        $refer = array(
            'error' => array(
                'validLogin' => 1
            ),
            'data' => array(
                'setLogin' => 'AnyLogin'
            )
        );
        $this->referData($refer);
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin" minlength="2">', $this->_user->inputLogin());
    }

    public function testGetInputEmailWithReferEmailData()
    {
        $refer = array(
            'data' => array(
                'setEmail' => 'any@email.com'
            )
        );
        $this->referData($refer);
        $this->assertEquals('<input type="email" name="userEmail" required class="form-control" id="userEmail" value="any@email.com">', $this->_user->inputEmail());
    }

    public function testGetInputEmailWithInccorectEmail()
    {
        $refer = array(
            'error' => array(
                'validEmail' => 1
            ),
            'data' => array(
                'setEmail' => 'any@email.com'
            )
        );
        $this->referData($refer);
        $this->assertEquals('<input type="email" name="userEmail" required class="form-control" id="userEmail">', $this->_user->inputEmail());
    }

    public function testAddAccountValue()
    {
        $stub = \Mockery::mock('ViewHelper\User');
        $stub->shouldReceive('getUserSession')->andReturnSelf()->once();
        $stub->shouldReceive('getLogin')->once();
        $stub->shouldReceive('getEmail')->once();
        $this->_user = new User($this->mockForm('accountData'));
        MockTest::inject($this->_user, '_user', $stub);
        MockTest::callMockMethod($this->_user, 'addAccountValue', array('userLogin'));
        MockTest::callMockMethod($this->_user, 'addAccountValue', array('userEmail'));
    }

    public function testGetLoginEntityGetter()
    {
        $this->assertEquals(
            'getLogin',
            MockTest::callMockMethod($this->_user, 'getEntityGetter', array('userLogin'))
        );
    }

    public function testGetEmailEntityGetter()
    {
        $this->assertEquals(
            'getEmail',
            MockTest::callMockMethod($this->_user, 'getEntityGetter', array('userEmail'))
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
        MockTest::injectStatic('App\Resource\Server', 'readReferDataArray', $data);
    }
}
