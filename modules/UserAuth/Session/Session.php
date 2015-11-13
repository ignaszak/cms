<?php

namespace UserAuth\Session;

class Session
{

    private static $_user;
    private static $_userLoginAuth;
    
    public function __construct($userLoginAuthObject)
    {
        self::$_user = \UserAuth\User::instance();
        self::$_userLoginAuth = $userLoginAuthObject;
    }

    public function login()
    {
        $_SESSION[self::$_user->getSesionName()] = self::$_userLoginAuth->getUserEntity();
        self::$_user->catchUserSession();
    }

    public function logout()
    {
        unset($_SESSION[self::$_user->getSesionName()]);
        self::$_user->catchUserSession();
    }
}
