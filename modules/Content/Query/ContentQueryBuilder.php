<?php

namespace Content\Query;

use Conf\DB\DBDoctrine;

class ContentQueryBuilder implements IContentQueryBuilder
{

    private $_contentQuery;

    public function __construct(IContentQuery $_contentQuery)
    {
        $this->_contentQuery = $_contentQuery;
    }

    public function id($value): IContentQuery
    {
        $this->set('c.id', $value);
        return $this->_contentQuery;
    }

    public function categoryId($value): IContentQuery
    {
        $this->set('c.categoryId', $value);
        return $this->_contentQuery;
    }

    public function categoryAlias(string $value): IContentQuery
    {
        $column = 'category.alias';
        $this->join($column);
        $this->set($column, $value);
        return $this->_contentQuery;
    }

    public function authorId($value): IContentQuery
    {
        $this->set('c.authorId', $value);
        return $this->_contentQuery;
    }

    public function authorLogin(string $value): IContentQuery
    {
        $column = 'user.login';
        $this->join($column);
        $this->set($column, $value);
        return $this->_contentQuery;
    }

    public function date(string $value): IContentQuery
    {
        $date = explode('-', $value);

        $emConfig = DBDoctrine::em()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('DATE_FORMAT', 'DoctrineExtensions\Query\Mysql\DateFormat');

        $format = "";
        if (array_key_exists(0, $date)) $format = "%Y";
        if (array_key_exists(1, $date)) $format .= "-%c";
        if (array_key_exists(2, $date)) $format .= "-%d";

        $this->set('DATE_FORMAT(c.date, \''.$format.'\')', $value);

        return $this->_contentQuery;
    }

    public function title(string $value): IContentQuery
    {
        $this->set('c.title', $value);
        return $this->_contentQuery;
    }

    public function alias(string $value): IContentQuery
    {
        $this->set('c.alias', $value);
        return $this->_contentQuery;
    }

    public function contentLike(string $value): IContentQuery
    {
        $query = $this->_contentQuery->contentQuery
            ->andwhere('c.content LIKE :value')
            ->setParameter('value', '%'.$value.'%');
        $this->_contentQuery->contentQuery = $query;
        return $this->_contentQuery;
    }

    private function join(string $column)
    {
        $reference = $this->getReference($column);

        $query = $this->_contentQuery->contentQuery
            ->join('c.'.$reference, $reference);

        $this->_contentQuery->contentQuery = $query;
    }

    private function set(string $column, $value)
    {
        $query = $this->_contentQuery->contentQuery
            ->andwhere($column.' IN(:value)')
            ->setParameter('value', $value);

        $this->_contentQuery->contentQuery = $query;
    }

    private function getReference(string $column): string
    {
        $array = explode('.', $column);
        return $array[0];
    }

}
