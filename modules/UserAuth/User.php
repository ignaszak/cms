<?php

namespace UserAuth;

use Conf\DB\DBDoctrine;

class User
{

    private static $_user;
    private $userSession;
    private $sessionName;

    final static function instance()
    {
        if (empty(self::$_user))
            self::$_user = new self;
    
        return self::$_user;
    }

    public function __construct()
    {
        $this->setSessionName(md5('session'));
        $this->catchUserSession();
    }

    public function getSesionName()
    {
        return $this->sesionName;
    }

    private function setSessionName($sessionName)
    {
        $this->sesionName = $sessionName;
    }

    public function isUserLoggedIn()
    {
        return isset($this->userSession) && DBDoctrine::em()
            ->getRepository('\Entity\Users')
            ->findBy(array(
                'login' => $this->userSession->getLogin(),
                'password' => $this->userSession->getPassword()
            ));
    }

    public function getUserSession()
    {
        return $this->userSession;
    }

    public function catchUserSession()
    {
        if (isset($_SESSION[$this->getSesionName()])) {
            $this->userSession = $_SESSION[$this->getSesionName()];
        } elseif (isset($_COOKIE[$this->sessionName])) {
            $this->userSession = $_COOKIE[$this->getSesionName()];
        }
    }

    public function login($userEmailOrLogin, $userPassword, $userRemember)
    {
        $userLoginAuth = new UserLoginAuth;
        $userLoginAuth->login($userEmailOrLogin, $userPassword, $userRemember);
    }

    public function logout()
    {
        $userLoginAuth = new UserLoginAuth;
        $userLoginAuth->logout();
    }

    public function registration($userLogin, $userEmail, $userPassword, $userRePassword)
    {
        $userRegistrationAuth = new UserRegistrationAuth;
        $userRegistrationAuth->registration($this, $userLogin, $userEmail, $userPassword, $userRePassword);
    }
}
