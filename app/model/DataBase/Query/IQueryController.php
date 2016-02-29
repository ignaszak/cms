<?php
namespace DataBase\Query;

abstract class IQueryController
{

    /**
     *
     * @var QueryBuilder
     */
    protected $_queryBuilder;

    /**
     * Contains query rows count
     *
     * @var integer
     */
    protected static $countQuery;

    /**
     *
     * @var \Conf\DB\DBDoctrine::em()->createQueryBuilder()
     */
    protected $query;

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

    public function updateQuery($value)
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
        if (method_exists($this->_queryBuilder, $name)) {
            return call_user_func_array(
                [$this->_queryBuilder, $name],
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
