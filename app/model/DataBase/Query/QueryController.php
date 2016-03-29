<?php
namespace DataBase\Query;

use Conf\Conf;
use Conf\DB\DBDoctrine;
use App\Resource\RouterStatic as Router;
use Ignaszak\Registry\RegistryFactory;

class QueryController extends IQueryController
{

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     * Entity name from \Entity\Controller\EntityController
     *
     * @var string
     */
    private $entityName;

    /**
     *
     * @var boolean
     */
    private $isResultForced = false;

    /**
     * Stores result of createQueryBuilder method
     *
     * @var Entity[]
     */
    private $entityArray = [];

    /**
     *
     * @var boolean
     */
    private $isPaginationEnabled = false;

    /**
     *
     * @var integer
     */
    private $limit;

    /**
     *
     * @var string (public|edit|all)
     */
    private $status;

    /**
     * Used to disable QueryController::orderHandler() when user
     * defines his own orderBy
     *
     * @var boolean
     */
    private $enableOrderHandler = true;

    public function __construct(string $entityName)
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->_queryBuilder = new QueryBuilder($this);
        $this->entityName = $entityName;
        $this->createQuery();
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryController::paginate($paginate)
     */
    public function paginate(bool $paginate = true): IQueryController
    {
        $this->isPaginationEnabled = $paginate;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryController::force()
     */
    public function force(): IQueryController
    {
        $this->isResultForced = true;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryController::limit($limit)
     */
    public function limit(int $limit): IQueryController
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryController::status($value)
     */
    public function status(string $value): IQueryController
    {
        $this->status = $value;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryController::orderBy($column, $order)
     */
    public function orderBy(string $column, string $order)
    {
        $query = $this->query->orderBy('c.' . $column, $order);
        $this->query = $query;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryController::getQuery()
     */
    public function getQuery(): array
    {
        $this->statusHandler();
        $this->orderHandler();
        $this->queryController();

        if (! $this->isPaginationEnabled) {
            $this->getQueryAndResult();
        }

        $this->countQuery();

        return $this->entityArray;
    }

    /**
     * Selects entity sets createQueryBuilder()
     */
    private function createQuery()
    {
        $query = DBDoctrine::em()->createQueryBuilder()
            ->select('c')
            ->from($this->entityName, 'c');

        $this->query = $query;
    }

    /**
     * In admin panel it is possible to select 'all', 'public' or 'edit' post
     * by calling QueryController::status(string $value) method
     * In other cases handler select only 'public' posts
     */
    private function statusHandler()
    {
        // For entities which have getPublic method
        if (method_exists($this->entityName, 'getPublic')) {
            $value = 1;
            if (Router::getName() == 'admin') { // Check if admin panel is avilable
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
                $query = $this->query->andwhere('c.public = ' . $value);
                $this->query = $query;
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
     * or result is forced and select paginated rows.
     * If alias exists
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
     *
     * @return boolean
     */
    private function isAliasEmptyOrIsResultForced(): bool
    {
        return empty(Router::getParam('alias')) || $this->isResultForced;
    }

    /**
     * Creates query to paginate rows
     */
    private function paginateQuery()
    {
        $page = Router::getParam('page');
        $limit = $this->_conf->getViewLimit();
        $offset = $limit * (($page ? $page : 1) - 1);

        $query = $this->query->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getResult();

        $this->entityArray = $query;
    }

    /**
     * Checks if any limit of selected rows is set.
     * If it is sets max
     * result in doctrine query builder.
     */
    private function setLimit()
    {
        if (is_null($this->limit) === false) {
            $query = $this->query->setMaxResults($this->limit);
            $this->query = $query;
        }
    }

    /**
     * If result is not forced select rows by alias from router
     */
    private function setAliasIfResultIsNotForced()
    {
        if (! $this->isResultForced) {
            $this->_queryBuilder->alias(Router::getParam('alias'));
            $this->getQueryAndResult();
        }
    }

    private function getQueryAndResult()
    {
        $query = $this->query->getQuery()->getResult();

        $this->entityArray = $query;
    }

    private function countQuery()
    {
        $query = $this->query->select('COUNT(c)')
            ->getQuery()
            ->getSingleScalarResult();

        parent::$countQuery = $query;
    }
}
