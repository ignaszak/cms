<?php
namespace Pagination\Theme;

use Pagination\PaginationGenerator;

abstract class Theme
{

    /**
     *
     * @var PaginationGenerator
     */
    protected $_pg;

    /**
     *
     * @param PaginationGenerator $_pg
     */
    public function __construct(PaginationGenerator $_pg)
    {
        $this->_pg = $_pg;
    }

    /**
     * @return string
     */
    abstract public function getTheme(): string;
}
