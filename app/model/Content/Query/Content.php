<?php
namespace Content\Query;

use Ignaszak\Registry\RegistryFactory;

class Content
{

    /**
     *
     * @var ContentQueryController
     */
    private $_contentQueryController;

    /**
     *
     * @param string $name
     *            entity name from \Entity\Controller\EntityController
     * @return IContentQueryController
     */
    public function setContent(string $name): IContentQueryController
    {
        $entityController = RegistryFactory::start()->register('Entity\Controller\EntityController');
        $entityName = $entityController->getEntity($name);
        $this->_contentQueryController = new ContentQueryController($entityName);
        
        return $this->_contentQueryController;
    }

    /**
     *
     * @return Entity[]
     */
    public function getContent(): array
    {
        return $this->_contentQueryController->getContent();
    }
}
