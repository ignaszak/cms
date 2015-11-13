<?php

namespace UserAuth;

class UserLoginAuth extends UserAuth
{

    private $userLoginOrEmail;
    private $userRemember;

    public function login($userLoginOrEmail, $userPassword, $userRemember)
    {
        $this->setUserLoginData($userLoginOrEmail, $userPassword, $userRemember);
        $this->validUserLoginData();
        $this->validUserWithDataBase();
        $this->setUserSession();
    }

    public function logout()
    {
        $session = new Session\Session($this);
        $session->logout();
    }

    private function setUserLoginData($userLoginOrEmail, $userPassword, $userRemember)
    {
        $this->userLoginOrEmail = $userLoginOrEmail;
        $this->userPassword = $userPassword;
        $this->userRemember = $userRemember;
    }

    private function validUserLoginData()
    {
        $isValidEmailOrLogin = $this->_userValid->validEmailOrUserName($this->userLoginOrEmail);
        $isValidUserPassword = $this->_userValid->validUserPassword($this->userPassword);
    
        if (!$isValidEmailOrLogin or !$isValidUserPassword) {
            \System\System::setReferData(array('incorrectLoginData'=>1));
            \System\System::headerLocationReferer();
        }
    }

    private function validUserWithDataBase()
    {
        $user = $this->_em->getRepository('\Entity\Users')->findBy(array(
            $this->returnUserLoginColumnName() => $this->userLoginOrEmail
        ));

        if (count($user) == 1 && HashPass::verifyPassword($this->userPassword, $user[0]->getPassword())) {
            $this->_userEntity = $user[0];
        } else {
            \System\System::setReferData(array('incorrectLoginData'=>1));
            \System\System::headerLocationReferer();
        }
    }

    private function returnUserLoginColumnName()
    {
        return ($this->_userValid->validUserName($this->userLoginOrEmail) ? 'login' : 'email');
    }

}
