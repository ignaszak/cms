<?php

namespace ContentController;

use Entity\Posts;

class PostController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_entity = new Posts;
    }

    public function insert()
    {
        $this->validAndAddToEntity(array('CategoryId', 'AuthorId', 'Date', 'Title', 'Alias', 'Content'));
        $this->_em->persist($this->_entity);
        $this->_em->flush($this->_entity);
    }

}
