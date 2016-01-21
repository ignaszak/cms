<?php
namespace Content\Controller;

use Entity\Users;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_entity = new Users();
    }

    public function insert()
    {
        $this->validAndAddToEntity(array(
            'Login',
            'Email',
            'Password',
            'RegDate',
            'LogDate',
            'Role'
        ));
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }

    public function update()
    {
        $this->validAndAddToEntity(array());
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }
}
