<?php

namespace UserAuth;

use Conf\DB\DBDoctrine;
use Validation\UserValidation;

class UserAuth
{

    protected $_em;
    protected $_user;
    protected $_userValid;
    protected $_userEntity;
    protected $userPassword;

    public function __construct(User $_user)
    {
        $this->_em = DBDoctrine::em();
        $this->_user = $_user;
        $this->_userValid = new UserValidation;
    }

}
