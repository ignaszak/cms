<?php
namespace DataBase\Query;

use Ignaszak\Registry\RegistryFactory;

class Query
{

    /**
     *
     * @var QueryController
     */
    private $queryController = null;

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
        $this->queryController = new QueryController($entityName);

        return $this->queryController;
    }

    /**
     *
     * @return Entity[]
     */
    public function getQuery(): array
    {
        $this->queryController->paginate(true);
        return $this->queryController->getQuery();
    }

    /**
     *
     * @return Entity[]
     */
    public function getStaticQuery(): array
    {
        $this->queryController->force();
        return $this->queryController->getQuery();
    }
}
