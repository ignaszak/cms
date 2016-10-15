<?php
namespace Pagination\Theme;

use Pagination\PaginationGenerator;

abstract class Theme
{

    /**
     *
     * @var PaginationGenerator
     */
    protected $pg = null;

    /**
     *
     * @param PaginationGenerator $pg
     */
    public function __construct(PaginationGenerator $pg)
    {
        $this->pg = $pg;
    }

    /**
     * @return string
     */
    abstract public function getTheme(): string;
}
