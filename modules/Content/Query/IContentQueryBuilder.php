<?php

namespace Content\Query;

interface IContentQueryBuilder
{

    public function id($value): IContentQuery;
    public function categoryId($value): IContentQuery;
    public function categoryAlias(string $value): IContentQuery;
    public function authorId($value): IContentQuery;
    public function authorLogin(string $value): IContentQuery;
    public function date(string $value): IContentQuery;
    public function title(string $value): IContentQuery;
    public function alias(string $value): IContentQuery;
    public function contentLike(string $value): IContentQuery;

}
