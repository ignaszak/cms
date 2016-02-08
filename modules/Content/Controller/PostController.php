<?php
namespace Content\Controller;

use Entity\Posts;

class PostController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_entity = new Posts();
    }

    public function insert()
    {
        $this->validSetters([
            'Category',
            'Author',
            'Date',
            'Title',
            'Alias',
            'Content'
        ]);
        $this->callEntitySettersFromArray();
        $this->_em->persist($this->_entity);
        $this->_em->flush();
    }
}
