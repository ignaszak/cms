<?php
namespace DataBase\Query;

use Ignaszak\Registry\RegistryFactory;

class Query
{

    /**
     *
     * @var QueryController
     */
    private $_queryController;

    /**
     *
     * @param string $name entity name from \Entity\Controller\EntityController
     * @return IQueryController
     */
    public function setQuery(string $name): IQueryController
    {
        $entityController = RegistryFactory::start()
            ->register('Entity\Controller\EntityController');
        $entityName = $entityController->getEntity($name);
        $this->_queryController = new QueryController($entityName);

        return $this->_queryController;
    }

    /**
     *
     * @return Entity[]
     */
    public function getQuery(): array
    {
        $this->_queryController->paginate(true);
        return $this->_queryController->getQuery();
    }

    /**
     *
     * @return Entity[]
     */
    public function getStaticQuery(): array
    {
        $this->_queryController->force();
        return $this->_queryController->getQuery();
    }
}
