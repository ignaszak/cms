<?php

namespace UserAuth;

use Conf\DB\DBDoctrine;

class UserAuth
{

    protected $_em;
    protected $_userValid;
    protected $_userEntity;
    protected $userPassword;

    public function __construct()
    {
        $this->_em = DBDoctrine::getEntityManager();
        $this->_userValid = new Validation\UserValidation;
    }

    public function getUserEntity()
    {
        return $this->_userEntity;
    }

    protected function setUserSession()
    {
        //if ($this->userRemember) {
        $session = new Session\Session($this);
        $session->login();
        //}
    }

}
