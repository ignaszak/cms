<?php
namespace Content\Controller;

use Entity\MenuItems;

class MenuItemsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_entity = new MenuItems();
    }

    public function insert()
    {
        $this->validSetters([]);
        $this->callEntitySettersFromArray();
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }
}
