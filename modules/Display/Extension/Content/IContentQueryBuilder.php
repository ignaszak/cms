<?php

namespace Display\Extension\Content;

interface IContentQueryBuilder
{

    public function paginate($paginate = true);
    public function id($value);
    public function categoryId($value);
    public function categoryAlias($value);
    public function authorId($value);
    public function authorLogin($value);
    public function date($value);
    public function title($value);
    public function alias($value);
    public function contentLike($value);

}
