<?php

namespace Content\Query;

use CMSException\InvalidClassException;

abstract class IContentQuery
{

    protected static $countQuery;
    protected $_contentQueryBuilder;
    protected $contentQuery;

    abstract public function getContent();
    abstract public function paginate(bool $paginate = true): IContentQuery;
    abstract public function force(): IContentQuery;
    abstract public function limit(int $limit): IContentQuery;

    public static function getCountQuery()
    {
        return self::$countQuery;
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property))
            $this->$property = $value;
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

    public function __call($name, $arguments)
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

}
