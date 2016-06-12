<?php
namespace DataBase\Command\Decorator;

use DataBase\Command\Command;
use Ignaszak\Registry\RegistryFactory;

class ConfDecorator extends Command
{

    public function insert(array $array = []): Command
    {
        parent::insert($array);
        RegistryFactory::start('file')->remove('Conf\Conf');

        return $this;
    }

    /**
     * Disable remove
     *
     * {@inheritDoc}
     * @see \Content\Controller\Command::remove()
     */
    public function remove(): Command
    {
        return $this;
    }
}
