<?php

namespace UserAuth;

class UserRegistrationAuth extends UserAuth
{

    private $userRePassword;
    private $userLogin;
    private $userEmail;
    private $errorDoubledDataArray = array();

    public function registration(User $_user, $userLogin, $userEmail, $userPassword, $userRePassword)
    {
        if ($_user->isUserLoggedIn()) {
            \System\Server::setReferData(array('userMustBeLogout'=>1));
            \System\Server::headerLocationReferer();
        }

        $this->setUserRegistrationData($userLogin, $userEmail, $userPassword, $userRePassword);
        $this->validUserRegistrationData();
        $this->validColumnDataBaseWithRegistrationData('login', $this->userLogin);
        $this->validColumnDataBaseWithRegistrationData('email', $this->userEmail);
        $this->sendErrorsIfExists();
        $this->addNewUserToDataBase();
        $this->setRefererMessage();
    }

    private function setUserRegistrationData($userLogin, $userEmail, $userPassword, $userRePassword)
    {
        $this->userLogin = $userLogin;
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
        $this->userRePassword = $userRePassword;
    }

    private function validUserRegistrationData()
    {
        $isValidLogin = $this->_userValid->validUserName($this->userLogin);
        $isValidEmail = $this->_userValid->validUserEmail($this->userEmail);
        $isValidPassword = $this->_userValid->validUserPassword($this->userPassword,
            $this->userRePassword, 'REGISTRATION');

        $registrationErrorArray = array();

        if (!$isValidLogin) $registrationErrorArray['incorrectLogin'] = 1;
        if (!$isValidEmail) $registrationErrorArray['incorrectEmail'] = 1;
        if (!$isValidPassword) $registrationErrorArray['incorrectPassword'] = 1;

        if (!$isValidLogin or !$isValidEmail or !$isValidPassword) {
            \System\Server::setReferData($registrationErrorArray);
            \System\Server::headerLocationReferer();
        }
    }

    private function validColumnDataBaseWithRegistrationData($column, $registrationData)
    {
        $user = $this->_em->getRepository('\Entity\Users')->findBy(array(
            $column => $registrationData
        ));

        if (count($user) > 0) {
            $this->errorDoubledDataArray = array_merge($this->errorDoubledDataArray,
                array('form'.ucfirst($column).'Doubled'=>1));
        }
    }

    private function sendErrorsIfExists()
    {
        if (count($this->errorDoubledDataArray) > 0) {
            \System\Server::setReferData($this->errorDoubledDataArray);
            \System\Server::headerLocationReferer();
        }
    }

    private function addNewUserToDataBase()
    {
        $user = new \Entity\Users;
        $user->setLogin($this->userLogin);
        $user->setEmail($this->userEmail);
        $user->setPassword(HashPass::hash($this->userPassword));
        $user->setRegDate(new \DateTime("now"));
        $user->setLogDate(new \DateTime("now"));
        $user->setRole('user');

        $this->_em->persist($user);
        $this->_em->flush();
    }
    
    private function setRefererMessage()
    {
        \System\Server::setReferData(array('registrationSuccess'=>1));
    }

}
