<?php
namespace Pagination;

class Pagination
{

    /**
     *
     * @var Theme\PaginationTheme
     */
    private $_paginationTheme;

    /**
     *
     * @var PaginationGenerator
     */
    private $_pg;

    public function __construct()
    {
        $this->_pg = new PaginationGenerator();
    }

    /**
     *
     * @return \Pagination\PaginationGenerator
     */
    public function customPagination(): PaginationGenerator
    {
        return $this->_pg;
    }

    /**
     *
     * @param string $theme
     * @return string
     */
    public function getPaginationTheme(string $theme = "pagination"): string
    {
        switch ($theme) {
            case "pagination":
                $this->_paginationTheme = new Theme\MultiPage($this->_pg);
                break;
            case "pager":
                $this->_paginationTheme = new Theme\Pager($this->_pg);
                break;
            case "pager-align":
                $this->_paginationTheme = new Theme\PagerAlign($this->_pg);
                break;
        }

        return $this->_paginationTheme->getTheme();
    }
}
