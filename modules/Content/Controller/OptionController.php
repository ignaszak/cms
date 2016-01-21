<?php
namespace Content\Controller;

use Entity\Options;
use Ignaszak\Registry\RegistryFactory;

class OptionController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_entity = new Options();
    }

    public function insert()
    {
        $this->validAndAddToEntity(array());
        $this->_em->persist($this->_entity);
        $this->_em->flush();
        RegistryFactory::start('file')->remove('Conf\Conf');
    }

    public function remove()
    {
    }
}
