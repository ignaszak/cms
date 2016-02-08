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
        $this->validSetters([
            'Login',
            'Email',
            'Password',
            'RegDate',
            'LogDate',
            'Role'
        ]);
        $this->callEntitySettersFromArray();
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }

    public function update(array $array = [])
    {
        $this->validSetters($array);
        $this->callEntitySettersFromArray();
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }
}
