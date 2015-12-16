<?php

namespace Display\Extension;

use Ignaszak\Registry\RegistryFactory;

class User
{

    private $_user;

    public function __construct()
    {
        $this->_user = RegistryFactory::start()->get('user');
    }

    public function isUserLoggedIn()
    {
        return $this->_user->isUserLoggedIn();
    }

    public function getUserId()
    {
        return $this->_user->getUserSession()->getId();
    }

    public function getUserLogin()
    {
        return $this->_user->getUserSession()->getLogin();
    }

    public function getUserEmail()
    {
        return $this->_user->getUserSession()->getEmail();
    }

    public function getUserRegistrationDate($format = "")
    {
        return $this->_user->getUserSession()->getRegDate($format);
    }

    public function getUserLoginDate($format = "")
    {
        return $this->_user->getUserSession()->getLogDate($format);
    }

    public function getUserRole()
    {
        return $this->_user->getUserSession()->getRole();
    }

}
