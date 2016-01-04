<?php

namespace Content\Query;

interface IContentQueryBuilder
{

    /**
     * @param integer|array $value to select by one or multiples id
     * @return \Content\Query\IContentQueryController
     */
    public function id($value): IContentQueryController;

    /**
     * @param integer|array $value to select by one or multiples id
     * @return \Content\Query\IContentQueryController
     */
    public function categoryId($value): IContentQueryController;

    /**
     * @param string $value
     * @return \Content\Query\IContentQueryController
     */
    public function categoryAlias(string $value): IContentQueryController;

    /**
     * @param integer|array $value to select by one or multiples id
     * @return \Content\Query\IContentQueryController
     */
    public function authorId($value): IContentQueryController;

    /**
     * @param string $value
     * @return \Content\Query\IContentQueryController
     */
    public function authorLogin(string $value): IContentQueryController;

    /**
     * @param string $value
     * @return \Content\Query\IContentQueryController
     */
    public function date(string $value): IContentQueryController;

    /**
     * @param string $value
     * @return \Content\Query\IContentQueryController
     */
    public function title(string $value): IContentQueryController;

    /**
     * @param string $value
     * @return \Content\Query\IContentQueryController
     */
    public function alias(string $value): IContentQueryController;

    /**
     * @param string $value
     * @return \Content\Query\IContentQueryController
     */
    public function contentLike(string $value): IContentQueryController;

    /**
     * @param string $value
     * @return \Content\Query\IContentQueryController
     */
    public function titleLike(string $value): IContentQueryController;

}
