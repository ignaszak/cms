<?php

namespace Content\Query;

use Conf\Conf;
use Conf\DB\DBDoctrine;
use System\Router\Storage as Router;
use Ignaszak\Registry\RegistryFactory;

class ContentQueryController extends IContentQueryController
{

    /**
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     * Entity name from \Entity\Controller\EntityController
     * @var string
     */
    private $entityName;

    /**
     * @var string
     */
    private $isResultForced = false;

    /**
     * Stores result of createQueryBuilder method
     * 
     * @var Entity[]
     */
    private $entityContentArray = array();

    /**
     * @var boolean
     */
    private $isPaginationEnabled = true;

    /**
     * @var integer
     */
    private $limit;

    /**
     * @var string (public|edit|all)
     */
    private $status;

    /**
     * Used to disable ContentQueryController::orderHandler() when user
     * defines his own orderBy
     * 
     * @var boolean
     */
    private $enableOrderHandler = true;

    public function __construct(string $entityName)
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->_contentQueryBuilder = new ContentQueryBuilder($this);
        $this->entityName = $entityName;
        $this->createQuery();
    }

    /**
     * {@inheritDoc}
     * @see \Content\Query\IContentQueryController::paginate($paginate)
     */
    public function paginate(bool $paginate = true): IContentQueryController
    {
        $this->isPaginationEnabled = $paginate;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Content\Query\IContentQueryController::force()
     */
    public function force(): IContentQueryController
    {
        $this->isResultForced = true;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Content\Query\IContentQueryController::limit($limit)
     */
    public function limit(int $limit): IContentQueryController
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Content\Query\IContentQueryController::status($value)
     */
    public function status(string $value): IContentQueryController
    {
        $this->status = $value;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Content\Query\IContentQueryController::orderBy($column, $order)
     */
    public function orderBy(string $column, string $order)
    {
        $query = $this->contentQuery
            ->orderBy('c.' . $column, $order);
        $this->contentQuery = $query;
    }

    /**
     * {@inheritDoc}
     * @see \Content\Query\IContentQueryController::getContent()
     */
    public function getContent(): array
    {
        $this->statusHandler();
        $this->orderHandler();
        $this->queryController();

        if (!$this->isPaginationEnabled)
            $this->getQueryAndResult();

        $this->countQuery();

        return $this->entityContentArray;
    }

    /**
     * Selects entity sets createQueryBuilder()
     */
    private function createQuery()
    {
        $query = DBDoctrine::em()->createQueryBuilder()
            ->select('c')
            ->from($this->entityName, 'c');

        $this->contentQuery = $query;
    }

    /**
     * In admin panel it is possible to select 'all', 'public' or 'edit' post
     * by calling ContentQueryController::status(string $value) method
     * In other cases handler select only 'public' posts
     */
    private function statusHandler()
    {
        // For entities which have getPublic method
        if (method_exists($this->entityName, 'getPublic')) {
            $value = 1;
            if (Router::getRouteName() == 'admin') { // Check if admin panel is avilable
                if ($this->status == 'public') {
                    $value = 1;
                } elseif ($this->status == 'edit') {
                    $value = 0;
                } else {
                    $value = null;
                }
            }
            // Create query based on $value
            if (is_int($value)) {
                $query = $this->contentQuery
                    ->andwhere('c.public = '.$value);
                $this->contentQuery = $query;
            }
        }
    }

    private function orderHandler()
    {
        if (method_exists($this->entityName, 'getDate') && $this->enableOrderHandler) {
            $this->orderBy('date', 'DESC');
        }
    }

    /**
     * If pagination is enabled checks if alias from router is empty
     * or result is forced and select paginated rows. If alias exists
     * and result is not forced selects query by defined in router alias
     * 
     * If pagination is disabled selects query by defined in router alias
     * if result is not forced
     */
    private function queryController()
    {
        if ($this->isPaginationEnabled) {

            if ($this->isAliasEmptyOrIsResultForced()) {
                $this->paginateQuery();
            } else {
                $this->setLimit();
                $this->setAliasIfResultIsNotForced();
            }

        } else {
            $this->setLimit();
            $this->setAliasIfResultIsNotForced();
        }
    }

    /**
     * @return boolean
     */
    private function isAliasEmptyOrIsResultForced(): bool
    {
        return empty(Router::getRoute('alias')) || $this->isResultForced;
    }

    /**
     * Creates query to paginate rows
     */
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

    /**
     * Checks if any limit of selected rows is set. If it is sets max
     * result in doctrine query builder.
     */
    private function setLimit()
    {
        if (is_null($this->limit) === false) {
            $query = $this->contentQuery
                ->setMaxResults($this->limit);
            $this->contentQuery = $query;
        }
    }

    /**
     * If result is not forced select rows by alias from router
     */
    private function setAliasIfResultIsNotForced()
    {
        if (!$this->isResultForced) {
            $this->_contentQueryBuilder->alias(Router::getRoute('alias'));
            $this->getQueryAndResult();
        }
    }

    private function getQueryAndResult()
    {
        $query = $this->contentQuery
            ->getQuery()
            ->getResult();

        $this->entityContentArray = $query;
    }

    private function countQuery()
    {
        $query = $this->contentQuery
            ->select('COUNT(c)')
            ->getQuery()
            ->getSingleScalarResult();

        parent::$countQuery = $query;
    }

}
