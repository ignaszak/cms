<?php

namespace Content\Controller;

use Entity\Menus;

class MenuController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_entity = new Menus;
    }

    public function insert()
    {
        $this->validAndAddToEntity(array());
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }

    public function remove()
    {
        $this->_em->remove($this->_entity);
        $this->_em->flush($this->_entity);
    }

}
