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
        $this->validSetters(['Name', 'Position']);
        $this->callEntitySettersFromArray();
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }
}
