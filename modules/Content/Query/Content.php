<?php

namespace Content\Query;

class Content
{

    private $_contentQuery;

    public function setContent($name)
    {
        $entityController = \Entity\EntityController::instance();
        $entityName = $entityController->getEntityByName($name);
        $this->_contentQuery = new ContentQuery($entityName);

        return $this->_contentQuery;
    }

    public function getContent()
    {
        return $this->_contentQuery->getContent();
    }

}
