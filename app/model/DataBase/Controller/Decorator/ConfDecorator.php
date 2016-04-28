<?php
namespace DataBase\Controller\Decorator;

use DataBase\Controller\Controller;
use Ignaszak\Registry\RegistryFactory;

class ConfDecorator extends Controller
{

    public function insert(array $array = []): Controller
    {
        parent::insert($array);
        RegistryFactory::start('file')->remove('Conf\Conf');

        return $this;
    }

    /**
     * Disable remove
     *
     * {@inheritDoc}
     * @see \Content\Controller\Controller::remove()
     */
    public function remove(): Controller
    {
        return $this;
    }
}
