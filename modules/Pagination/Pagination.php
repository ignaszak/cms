<?php
namespace Pagination;

class Pagination
{

    private $_paginationTheme;

    private $_pg;

    public function __construct()
    {
        $this->_pg = new PaginationGenerator();
    }

    public function customPagination()
    {
        return $this->_pg;
    }

    public function getPaginationTheme($theme = "pagination")
    {
        switch ($theme) {
            case "pagination":
                $this->_paginationTheme = new MultiPage($this->_pg);
                break;
            case "pager":
                $this->_paginationTheme = new Pager($this->_pg);
                break;
            case "pager-align":
                $this->_paginationTheme = new PagerAlign($this->_pg);
                break;
        }
        
        return $this->_paginationTheme->getTheme();
    }
}
