<?php

namespace Display\Extension\Content;

abstract class IContentQuery
{

    protected static $countQuery;
    protected $contentQuery;
    protected $isPaginationEnabled = true;

    abstract public function getContent();
    abstract public function buildQuery();
    abstract public function force();

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

}
