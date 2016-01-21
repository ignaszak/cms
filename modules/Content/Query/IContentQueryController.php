<?php
namespace Content\Query;

use CMSException\InvalidClassException;

abstract class IContentQueryController
{

    /**
     *
     * @var ContentQueryBuilder
     */
    protected $_contentQueryBuilder;

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
    protected $contentQuery;

    /**
     *
     * @return Entity[]
     */
    abstract public function getContent(): array;

    /**
     * Defines if pagination is disabled
     *
     * @param bool $paginate
     * @return \Content\Query\IContentQueryController
     */
    abstract public function paginate(bool $paginate = true): IContentQueryController;

    /**
     * Force controller to select rows independ of alias
     *
     * @return \Content\Query\IContentQueryController
     */
    abstract public function force(): IContentQueryController;

    /**
     * Sets Limit of selected rows
     *
     * @param int $limit
     * @return \Content\Query\IContentQueryController
     */
    abstract public function limit(int $limit): IContentQueryController;

    /**
     * Selects 'public', 'edit' or 'all' rows
     *
     * @param unknown $value
     * @return \Content\Query\IContentQueryController
     */
    abstract public function status(string $value): IContentQueryController;

    /**
     *
     * @param string $column
     * @param string $order
     */
    abstract public function orderBy(string $column, string $order);

    public function setContentQuery($value)
    {
        $this->contentQuery = $value;
    }

    /**
     *
     * @param string $property
     * @return mixed Property of IContentQueryController
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
     * @throws InvalidClassException
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->_contentQueryBuilder, $name)) {
            
            return call_user_func_array(array(
                $this->_contentQueryBuilder,
                $name
            ), $arguments);
        } else {
            
            throw new InvalidClassException("No class correspond to <b>$name</b> method");
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
