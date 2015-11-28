<?php

namespace UserAuth;

use System\Server;

class UserLoginAuth extends UserAuth
{

    private $userEmailOrLogin;
    private $userRemember;

    public function login($userEmailOrLogin, $userPassword, $userRemember)
    {
        $this->setUserLoginData($userEmailOrLogin, $userPassword, $userRemember);
        $this->validUserLoginData();
        $this->validUserWithDataBase();
        $this->setUserSession();
    }

    public function logout()
    {
        $session = new Session\Session($this);
        $session->logout();
    }

    private function setUserLoginData($userEmailOrLogin, $userPassword, $userRemember)
    {
        $this->userEmailOrLogin = $userEmailOrLogin;
        $this->userPassword = $userPassword;
        $this->userRemember = $userRemember;
    }

    private function validUserLoginData()
    {
        $isValidEmailOrLogin = $this->_userValid->validEmailOrLogin($this->userEmailOrLogin);
        $isValidPassword = $this->_userValid->validPassword($this->userPassword);
    
        if (!$isValidEmailOrLogin or !$isValidPassword) {
            Server::setReferData(array('incorrectLoginData'=>1));
            Server::headerLocationReferer();
        }
    }

    private function validUserWithDataBase()
    {
        $user = $this->_em->getRepository('\Entity\Users')->findBy(array(
            $this->returnUserLoginColumnName() => $this->userEmailOrLogin
        ));

        if (count($user) == 1 && HashPass::verifyPassword($this->userPassword, $user[0]->getPassword())) {
            $this->_userEntity = $user[0];
        } else {
            Server::setReferData(array('incorrectLoginData'=>1));
            Server::headerLocationReferer();
        }
    }

    private function returnUserLoginColumnName()
    {
        return ($this->_userValid->validLogin($this->userEmailOrLogin) ? 'login' : 'email');
    }

}
