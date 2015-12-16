<?php

namespace Content\Query;

class ContentQueryBuilder implements IContentQueryBuilder
{

    private $_contentQuery;

    public function __construct(IContentQuery $_contentQuery)
    {
        $this->_contentQuery = $_contentQuery;
    }

    public function id(int $value): IContentQuery
    {
        $this->set('c.id', $value);
        return $this->_contentQuery;
    }

    public function categoryId(int $value): IContentQuery
    {
        $this->set('c.category_id', $value);
        return $this->_contentQuery;
    }

    public function categoryAlias(string $value): IContentQuery
    {
        $column = 'category.alias';
        $this->join($column);
        $this->set($column, $value);
        return $this->_contentQuery;
    }

    public function authorId(int $value): IContentQuery
    {
        $this->set('c.author_id', $value);
        return $this->_contentQuery;
    }

    public function authorLogin(string $value): IContentQuery
    {
        $column = 'user.login';
        $this->join($column);
        $this->set($column, $value);
        return $this->_contentQuery;
    }

    public function date(\DateTime $value): IContentQuery
    {
        $this->set('c.date', $value);
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
