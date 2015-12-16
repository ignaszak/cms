<?php

namespace Content\Query;

interface IContentQueryBuilder
{

    public function id(int $value): IContentQuery;
    public function categoryId(int $value): IContentQuery;
    public function categoryAlias(string $value): IContentQuery;
    public function authorId(int $value): IContentQuery;
    public function authorLogin(string $value): IContentQuery;
    public function date(\DateTime $value): IContentQuery;
    public function title(string $value): IContentQuery;
    public function alias(string $value): IContentQuery;
    public function contentLike(string $value): IContentQuery;

}
