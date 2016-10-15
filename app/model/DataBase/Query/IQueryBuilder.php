<?php
namespace DataBase\Query;

interface IQueryBuilder
{

    /**
     *
     * @param integer|array $value
     *            to select by one or multiples id
     * @return \DataBase\Query\IQueryController
     */
    public function id($value): IQueryController;

    /**
     *
     * @param integer|array $value
     *            to select by one or multiples id
     * @return \DataBase\Query\IQueryController
     */
    public function categoryId($value): IQueryController;

    /**
     *
     * @param string $value
     * @return \DataBase\Query\IQueryController
     */
    public function categoryAlias(string $value): IQueryController;

    /**
     *
     * @param integer|array $value
     *            to select by one or multiples id
     * @return \DataBase\Query\IQueryController
     */
    public function authorId($value): IQueryController;

    /**
     *
     * @param string $value
     * @return \DataBase\Query\IQueryController
     */
    public function authorLogin(string $value): IQueryController;

    /**
     *
     * @param string $value
     * @return \DataBase\Query\IQueryController
     */
    public function date(string $value): IQueryController;

    /**
     *
     * @param string $value
     * @return \DataBase\Query\IQueryController
     */
    public function title(string $value): IQueryController;

    /**
     *
     * @param string $value
     * @return \DataBase\Query\IQueryController
     */
    public function alias(string $value): IQueryController;

    /**
     *
     * @param string $value
     * @return \DataBase\Query\IQueryController
     */
    public function contentLike(string $value): IQueryController;

    /**
     *
     * @param string $value
     * @return \DataBase\Query\IQueryController
     */
    public function titleLike(string $value): IQueryController;

    /**
     *
     * @param string $column
     * @param string $value
     * @return \DataBase\Query\IQueryController
     */
    public function findBy(string $column, string $value): IQueryController;

    /**
     *
     * @param string $query
     * @param array $params
     * @return \DataBase\Query\IQueryController
     */
    public function query(string $query, array $params = null): IQueryController;
}
