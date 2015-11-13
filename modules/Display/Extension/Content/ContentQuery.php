<?php

namespace Display\Extension\Content;

use Conf\Conf;
use Conf\DB\DBDoctrine;

class ContentQuery extends IContentQuery
{

    private $_em;
    private $_conf;
    private $_contentQueryBuilder;
    private $entityName;
    private $isResultForced = false;
    private $entityContentArray = array();

    public function __construct($entityName)
    {
        $this->_conf = Conf::instance();
        $this->_em = DBDoctrine::getEntityManager();
        $this->_contentQueryBuilder = new ContentQueryBuilder($this);
        $this->entityName = $entityName;
        $this->createQuery();
    }

    public function getContent()
    {
        $this->queryController();

        if (!$this->isPaginationEnabled)
            $this->getQueryAndResult();

        $this->countQuery();

        return $this->entityContentArray;
    }

    public function buildQuery()
    {
        return $this->_contentQueryBuilder;
    }

    public function force()
    {
        $this->isResultForced = true;
    }

    private function countQuery()
    {
        $query = $this->contentQuery
        ->select('COUNT(c)')
        ->getQuery()
        ->getSingleScalarResult();

        parent::$countQuery = $query;
    }

    private function createQuery()
    {
        $query = $this->_em->createQueryBuilder()
            ->select('c')
            ->from($this->entityName, 'c');

        $this->contentQuery = $query;
    }

    private function queryController()
    {
        if ($this->isPaginationEnabled) {

            if ($this->isAliasEmptyOrIsResultForced()) {
                $this->paginateQuery();
            } else {
                $this->setAliasIfResultIsNotForced();
            }

        } else {
            $this->setAliasIfResultIsNotForced();
        }
    }

    private function isAliasEmptyOrIsResultForced()
    {
        $alias = \Ignaszak\Router\Client::getRoute('alias');

        if (empty($alias)) {
            return true;
        } else {
            return ($this->isResultForced ? true : false);
        }
    }

    private function setAliasIfResultIsNotForced()
    {
        if (!$this->isResultForced) {
            $alias = \Ignaszak\Router\Client::getRoute('alias');
            $this->_contentQueryBuilder->alias($alias);
            $this->getQueryAndResult();
        }
    }

    private function paginateQuery()
    {
        $page = \Ignaszak\Router\Client::getRoute('page');
        $limit = $this->_conf->getPostLimit();
        $offset = $limit * (($page ? $page : 1) - 1);

        $query = $this->contentQuery
            ->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getResult();

        $this->entityContentArray = $query;
    }

    private function getQueryAndResult()
    {
        $query = $this->contentQuery
            ->getQuery()
            ->getResult();

        $this->entityContentArray = $query;
    }

}
