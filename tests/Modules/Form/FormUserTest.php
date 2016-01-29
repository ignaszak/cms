<?php
namespace Test\Modules\Form;

use Form\FormUser;
use Test\Init\InitConf;
use Test\Mock\MockTest;

class FormUserTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Form
     */
    private $_formUser;

    public function setUp()
    {
        InitConf::run();
        $this->_formUser = new FormUser('registration');
    }

    public function tearDown()
    {
        $this->referData();
    }

    public function testGetFormActionRegistrationAdress()
    {
        $this->_formUser = new FormUser('registration');
        $adress = $this->_formUser->getFormActionAdress();
        $this->assertEquals('user/post/registration', $adress);
    }

    public function testGetFormActionLoginAdress()
    {
        $this->_formUser = new FormUser('login');
        $adress = $this->_formUser->getFormActionAdress();
        $this->assertEquals('user/post/login', $adress);
    }

    public function testGetFormActionLogoutAdress()
    {
        $this->_formUser = new FormUser('logout');
        $adress = $this->_formUser->getFormActionAdress();
        $this->assertEquals('user/post/logout', $adress);
    }

    public function testGetFormActionRemindAdress()
    {
        $this->_formUser = new FormUser('remind');
        $adress = $this->_formUser->getFormActionAdress();
        $this->assertEquals('user/post/remind', $adress);
    }

    public function testGetFormMessage()
    {
        $referData = array();
        $referData['form'] = 'registration';
        $referData['error']['incorrectLogin'] = 1;
        $referData['error']['formLoginDoubled'] = 1;
        $referData['error']['incorrectEmail'] = 1;
        $referData['error']['formEmailDoubled'] = 1;
        $referData['error']['incorrectPassword'] = 1;
        $this->referData($referData);
        $message = $this->_formUser->getFormMessage();
        $this->assertEquals('Incorrect login.<br>' . 'Login alredy exists.<br>' . 'Incorrect email.<br>' . 'Email alredy exists.<br>' . 'Incorrect password.', $message);
    }

    public function testGetEmptyFormMessage()
    {
        $this->assertEmpty($this->_formUser->getFormMessage());
    }

    public function testGetInputLogin()
    {
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin" value="">', $this->_formUser->inputLogin());
    }

    public function testGetInputLoginWithReferLoginData()
    {
        $refer = array(
            'data' => array(
                'setLogin' => 'AnyLogin'
            )
        );
        $this->referData($refer);
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin" value="AnyLogin">', $this->_formUser->inputLogin());
    }

    public function testGetInputLoginWithInccorectLogin()
    {
        $refer = array(
            'error' => array(
                'incorrectLogin' => 1
            ),
            'data' => array(
                'setLogin' => 'AnyLogin'
            )
        );
        $this->referData($refer);
        $this->assertEquals('<input type="text" name="userLogin" required class="form-control" id="userLogin">', $this->_formUser->inputLogin());
    }

    public function testGetInputEmailWithReferEmailData()
    {
        $refer = array(
            'data' => array(
                'setEmail' => 'any@email.com'
            )
        );
        $this->referData($refer);
        $this->assertEquals('<input type="email" name="userEmail" required class="form-control" id="userEmail" value="any@email.com">', $this->_formUser->inputEmail());
    }

    public function testGetInputEmailWithInccorectEmail()
    {
        $refer = array(
            'error' => array(
                'incorrectEmail' => 1
            ),
            'data' => array(
                'setEmail' => 'any@email.com'
            )
        );
        $this->referData($refer);
        $this->assertEquals('<input type="email" name="userEmail" required class="form-control" id="userEmail">', $this->_formUser->inputEmail());
    }

    private function referData($data = '')
    {
        MockTest::injectStatic('System\Server', 'readReferDataArray', $data);
    }
}
