<?php
namespace Content\Controller\Validator;

use Ignaszak\Registry\RegistryFactory;
use Entity\Controller\EntityController;

class UniqueValidator extends Validator
{

    /**
     *
     * @var \Content\Query\Content
     */
    private $_query;

    /**
     *
     * @var string
     */
    private $entityKey;

    /**
     *
     * {@inheritDoc}
     * @see \Content\Controller\Validator\Validator::valid()
     */
    public function valid(array $command)
    {
        $this->commandArray = $command;
        $this->setEntityKey();
        $this->setQuery();
        $this->unique();
    }

    private function setQuery()
    {
        $this->_query = RegistryFactory::start()->register('Content\Query\Content');
    }

    private function setEntityKey()
    {
        $entityController = new EntityController();
        $this->entityKey = $entityController->getEntityKey($this->entityName);
    }

    private function unique()
    {
        foreach ($this->commandArray as $column) {
            $value = $this->getSetter($column);
            if (! $this->dataNotExistInDatabase($column, $value)) {
                $this->setError('unique' . ucfirst($column));
            }
        }
    }

    /**
     *
     * @param string $column
     * @param mixed $value
     * @return boolean
     */
    private function dataNotExistInDatabase(string $column, $value): bool
    {
        $this->_query->setContent($this->entityKey)
            ->findBy($column, $value)
            ->force()
            ->paginate(false);
        $result = $this->_query->getContent();
        return count($result) === 0 ? true : false;
    }
}
