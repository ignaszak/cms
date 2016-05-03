<?php
namespace DataBase\Controller\Validator;

class UniqueValidator extends Validator
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $query = null;

    /**
     *
     * @var string
     */
    private $entityKey = '';

    /**
     *
     * {@inheritDoc}
     * @see \DataBase\Controller\Validator\Validator::valid()
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
        $this->query = $this->registry->register('DataBase\Query\Query');
    }

    private function setEntityKey()
    {
        $entityController = $this->registry
            ->register('Entity\Controller\EntityController');
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
        $query = $this->query->setQuery($this->entityKey);
        if (! empty($exception)) {
            $query->query("c.{$column} NOT IN(?0)", [$exception]);
        }
        $query->findBy($column, $value);
        $result = $this->query->getStaticQuery();
        return count($result) === 0 ? true : false;
    }
}
