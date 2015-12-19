<?php

namespace Content\Query;

use Ignaszak\Registry\RegistryFactory;

class Content
{

    private $_contentQuery;

    public function setContent($name)
    {
        $entityController = RegistryFactory::start()
            ->register('Entity\Controller\EntityController');
        $entityName = $entityController->getEntity($name);
        $this->_contentQuery = new ContentQuery($entityName);

        return $this->_contentQuery;
    }

    public function getContent()
    {
        return $this->_contentQuery->getContent();
    }

}
