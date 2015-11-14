<?php

namespace Display\Extension\Content;

class ContentQueryBuilder implements IContentQueryBuilder
{

    private $_contentQuery;

    public function __construct(IContentQuery $_contentQuery)
    {
        $this->_contentQuery = $_contentQuery;
    }

    public function id($value)
    {
        $this->set('c.id', $value);
        return $this;
    }

    public function categoryId($value)
    {
        $this->set('c.category_id', $value);
        return $this;
    }

    public function categoryAlias($value)
    {
        $column = 'category.alias';
        $this->join($column);
        $this->set($column, $value);
        return $this;
    }

    public function authorId($value)
    {
        $this->set('c.author_id', $value);
        return $this;
    }

    public function authorLogin($value)
    {
        $column = 'user.login';
        $this->join($column);
        $this->set($column, $value);
        return $this;
    }

    public function date($value)
    {
        $this->set('c.date', $value);
        return $this;
    }

    public function title($value)
    {
        $this->set('c.title', $value);
        return $this;
    }

    public function alias($value)
    {
        $this->set('c.alias', $value);
        return $this;
    }

    public function contentLike($value)
    {
        $query = $this->_contentQuery->contentQuery
            ->andwhere('c.content LIKE :value')
            ->setParameter('value', '%'.$value.'%');
        $this->_contentQuery->contentQuery = $query;
        return $this;
    }

    private function join($column)
    {
        $reference = $this->getReference($column);

        $query = $this->_contentQuery->contentQuery
            ->join('c.'.$reference, $reference);

        $this->_contentQuery->contentQuery = $query;
    }

    private function set($column, $value)
    {
        $query = $this->_contentQuery->contentQuery
            ->andwhere($column.' IN(:value)')
            ->setParameter('value', $value);

        $this->_contentQuery->contentQuery = $query;
    }

    private function getReference($column)
    {
        $array = explode('.', $column);
        return $array[0];
    }

}
