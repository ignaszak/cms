<?php

namespace UserAuth;

use Conf\DB\DBDoctrine;
use Ignaszak\Registry\RegistryFactory;

class User
{

    private static $_user;
    private $userSession;

    final static function instance()
    {
        if (empty(self::$_user))
            self::$_user = new self;
    
        return self::$_user;
    }

    public function __construct()
    {
        $this->catchUserSession();
    }

    public function isUserLoggedIn()
    {
        return isset($this->userSession) && DBDoctrine::em()
            ->getRepository('Entity\Users')
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
        $session = RegistryFactory::start('session')->get('userSession');
        $cookie = RegistryFactory::start('cookie')->get('userSession');

        if ($session instanceof \Entity\Users) {
            $this->userSession = $session;
        } elseif ($cookie instanceof \Entity\Users) {
            $this->userSession = $cookie;
        }
    }

    public function login($userEmailOrLogin, $userPassword, $userRemember)
    {
        $userLoginAuth = new UserLoginAuth($this);
        $userLoginAuth->login($userEmailOrLogin, $userPassword, $userRemember);
    }

    public function logout()
    {
        $userLoginAuth = new UserLoginAuth($this);
        $userLoginAuth->logout();
    }

    public function registration($userLogin, $userEmail, $userPassword, $userRePassword)
    {
        $userRegistrationAuth = new UserRegistrationAuth($this);
        $userRegistrationAuth->registration($userLogin, $userEmail, $userPassword, $userRePassword);
    }
}
