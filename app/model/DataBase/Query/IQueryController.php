<?php
namespace DataBase\Query;

abstract class IQueryController
{

    /**
     * Contains query rows count
     *
     * @var integer
     */
    protected static $countQuery = 0;

    /**
     *
     * @var QueryBuilder
     */
    protected $queryBuilder = null;

    /**
     *
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $query = null;

    /**
     *
     * @return Entity[]
     */
    abstract public function getQuery(): array;

    /**
     * Defines if pagination is disabled
     *
     * @param bool $paginate
     * @return \DataBase\Query\IQueryController
     */
    abstract public function paginate(bool $paginate = true): IQueryController;

    /**
     * Force controller to select rows independ of alias
     *
     * @return \DataBase\Query\IQueryController
     */
    abstract public function force(): IQueryController;

    /**
     * Sets Limit of selected rows
     *
     * @param int $limit
     * @return \DataBase\Query\IQueryController
     */
    abstract public function limit(int $limit): IQueryController;

    /**
     * Selects 'public', 'edit' or 'all' rows
     *
     * @param unknown $value
     * @return \DataBase\Query\IQueryController
     */
    abstract public function status(string $value): IQueryController;

    /**
     *
     * @param string $column
     * @param string $order
     */
    abstract public function orderBy(string $column, string $order);

    /**
     *
     * @param \Doctrine\ORM\QueryBuilder $value
     */
    public function updateQuery(\Doctrine\ORM\QueryBuilder $value)
    {
        $this->query = $value;
    }

    /**
     *
     * @param string $property
     * @return mixed Property of IQueryController
     */
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @throws \RuntimeException
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->queryBuilder, $name)) {
            return call_user_func_array(
                [$this->queryBuilder, $name],
                $arguments
            );
        } else {
            throw new \RuntimeException(
                "No class correspond to <b>$name</b> method"
            );
        }
    }

    /**
     *
     * @return integer
     */
    public static function getCountQuery(): int
    {
        return self::$countQuery;
    }
}
