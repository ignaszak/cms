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
        foreach ($this->commandArray as $key => $val) {
            if (is_int($key)) {
                $column = $val;
                $exception = [];
            } else {
                $column = $key;
                $exception = $val;
            }
            $value = $this->getSetter($column);
            if (! $this->dataNotExistInDatabase($column, $value, $exception)) {
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
    private function dataNotExistInDatabase(string $column, $value, array $exception): bool
    {
        $query = $this->_query->setContent($this->entityKey);
        if (! empty($exception)) {
            $query->query("c.{$column} NOT IN(?0)", [$exception]);
        }
        $query->findBy($column, $value);
        $query->force()->paginate(false);
        $result = $this->_query->getContent();
        return count($result) === 0 ? true : false;
    }
}
