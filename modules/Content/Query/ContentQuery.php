<?php

namespace Content\Query;

use Conf\Conf;
use Conf\DB\DBDoctrine;
use System\Router\Storage as Router;
use CMSException\InvalidQueryException;
use Ignaszak\Registry\RegistryFactory;

class ContentQuery extends IContentQuery
{

    private $_em; //
    private $_conf; 
    private $entityName;
    private $isResultForced = false; //
    private $entityContentArray = array(); //
    private $isPaginationEnabled = true; //
    private $limit; //

    public function __construct($entityName)
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->_em = DBDoctrine::em();
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

    public function paginate(bool $paginate = true): IContentQuery
    {
        $this->isPaginationEnabled = $paginate;
        return $this;
    }

    public function force(): IContentQuery
    {
        $this->isResultForced = true;
        return $this;
    }

    public function limit(int $limit): IContentQuery
    {
        $this->limit = $limit;
        return $this;
    }

    private function countQuery()
    {
        $query = $this->contentQuery
        ->select('COUNT(c)')
        ->getQuery()
        ->getSingleScalarResult();

        $this->contentQuery = $query;
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
        $alias = Router::getRoute('alias');

        if (empty($alias)) {
            return true;
        } else {
            return $this->isResultForced;
        }
    }

    private function setAliasIfResultIsNotForced()
    {
        if (is_null($this->limit) === false) {
            $query = $this->contentQuery
                ->setMaxResults($this->limit);
            $this->contentQuery = $query;
        }

        if (!$this->isResultForced) {
            $alias = Router::getRoute('alias');
            $this->_contentQueryBuilder->alias($alias);
            $this->getQueryAndResult();
        }
    }

    private function paginateQuery()
    {
        $page = Router::getRoute('page');
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
