<?php
namespace DataBase\Query;

use Conf\DB\DBDoctrine;

class QueryBuilder implements IQueryBuilder
{

    /**
     *
     * @var IQueryController
     */
    private $queryController = null;

    /**
     *
     * @param IQueryController $queryController
     */
    public function __construct(IQueryController $queryController)
    {
        $this->queryController = $queryController;
    }

    /**
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::id($value)
     */
    public function id($value): IQueryController
    {
        $this->set('c.id', $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::categoryId($value)
     */
    public function categoryId($value): IQueryController
    {
        $this->set('c.categoryId', $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::categoryAlias($value)
     */
    public function categoryAlias(string $value): IQueryController
    {
        $column = 'category.alias';
        $this->join($column);
        $this->set($column, $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::authorId($value)
     */
    public function authorId($value): IQueryController
    {
        $this->set('c.authorId', $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::authorLogin($value)
     */
    public function authorLogin(string $value): IQueryController
    {
        $column = 'user.login';
        $this->join($column);
        $this->set($column, $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::date($value)
     */
    public function date(string $value): IQueryController
    {
        $date = explode('/', $value);
        $emConfig = DBDoctrine::em()->getConfiguration();
        $emConfig->addCustomDatetimeFunction(
            'DATE_FORMAT',
            'DoctrineExtensions\Query\Mysql\DateFormat'
        );
        $format = "";
        if (array_key_exists(0, $date)) {
            $format = "%Y";
        }
        if (array_key_exists(1, $date)) {
            $format .= "/%m";
        }
        if (array_key_exists(2, $date)) {
            $format .= "/%d";
        }
        $this->set("DATE_FORMAT(c.date, '{$format}')", $value);

        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::title($value)
     */
    public function title(string $value): IQueryController
    {
        $this->set('c.title', $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::alias($value)
     */
    public function alias(string $value): IQueryController
    {
        $this->set('c.alias', $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::contentLike($value)
     */
    public function contentLike(string $value): IQueryController
    {
        $this->like('content', $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::titleLike($value)
     */
    public function titleLike(string $value): IQueryController
    {
        $this->like('title', $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \DataBase\Query\IQueryBuilder::findBy($column, $value)
     */
    public function findBy(string $column, string $value): IQueryController
    {
        $this->set('c.' . $column, $value);
        return $this->queryController;
    }

    /**
     *
     * {@inheritDoc}
     * @see \DataBase\Query\IQueryBuilder::query($query, $params)
     */
    public function query(string $query, array $params = null): IQueryController
    {
        $query = $this->queryController->query
            ->andwhere($query);
        if (is_array($params)) {
            $query->setParameters($params);
        }
        $this->queryController->updateQuery($query);
        return $this->queryController;
    }

    /**
     *
     * @param string $column
     * @param string $value
     */
    private function like(string $column, string $value)
    {
        $query = $this->queryController->query
            ->andwhere('c.' . $column . ' LIKE :value')
            ->setParameter('value', '%' . $value . '%');
        $this->queryController->updateQuery($query);
    }

    /**
     *
     * @param string $column
     */
    private function join(string $column)
    {
        $reference = $this->getReference($column);

        $query = $this->queryController->query
            ->join('c.' . $reference, $reference);

        $this->queryController->updateQuery($query);
    }

    /**
     *
     * @param string $column
     * @param mixed $value
     */
    private function set(string $column, $value)
    {
        $query = $this->queryController->query
            ->andwhere($column . ' IN(:value)')
            ->setParameter('value', $value);

        $this->queryController->updateQuery($query);
    }

    /**
     *
     * @param string $column
     *            $return string
     */
    private function getReference(string $column): string
    {
        $array = explode('.', $column);
        return $array[0];
    }
}
