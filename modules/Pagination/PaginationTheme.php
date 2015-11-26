<?php

namespace Pagination;

use Conf\Conf;
use Content\Query\IContentQuery;

abstract class PaginationTheme
{

    protected $_pg;

    public function __construct(PaginationGenerator $_pg)
    {
        $this->_pg = $_pg;
    }

    abstract public function getTheme();

}
