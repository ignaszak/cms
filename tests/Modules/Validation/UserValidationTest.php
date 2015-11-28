<?php

namespace Test\Modules\Validation;

use Validation\UserValidation;

class UserValidationTest extends \PHPUnit_Framework_TestCase
{

    private $_userValidation;

    public function setUp()
    {
        $this->_userValidation = new UserValidation;
    }

    public function testValidLogin()
    {
        $login = "UserName";
        $ValidLogin = $this->_userValidation->validLogin($login);
        $this->assertTrue($ValidLogin);
    }

    public function testValidPassword()
    {
        $password = "password";
        $confirmPassword = "password";
        $ValidPassword = $this->_userValidation->validPassword($password);
        $this->assertTrue($ValidPassword);
        $ValidPasswordConfirm = $this->_userValidation->validPassword($password, $confirmPassword, "REGISTRATION");
        $this->assertTrue($ValidPasswordConfirm);
    }

    public function testValidEmail()
    {
        $email = "user@cms.com";
        $ValidEmail = $this->_userValidation->validEmail($email);
        $this->assertTrue($ValidEmail);
    }

    public function testValidEmailOrLogin()
    {
        $email = "user@cms.com";
        $login = "UserName";
        $ValidEmail = $this->_userValidation->validEmailOrLogin($email);
        $this->assertTrue($ValidEmail);
        $ValidLogin = $this->_userValidation->validEmailOrLogin($login);
        $this->assertTrue($ValidLogin);
    }

}
