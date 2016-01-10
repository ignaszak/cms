<?php

namespace Content\Controller;

use Entity\Categories;

class CategoryController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_entity = new Categories;
    }

    public function insert()
    {
        $this->validAndAddToEntity(array());
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }

}
