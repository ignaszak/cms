<?php

namespace Pagination;

class Pagination
{

    private $_iPagination;
    private $_pg;

    public function __construct()
    {
        $this->_pg = new PaginationGenerator;
    }

    public function customPagination()
    {
        return $this->_pg;
    }

    public function getPaginationTheme($theme = "pagination")
    {
        switch ($theme) {
            case "pagination":  $this->_iPagination = new MultiPage($this->_pg);  break;
            case "pager":       $this->_iPagination = new Pager($this->_pg);      break;
            case "pager-align": $this->_iPagination = new PagerAlign($this->_pg); break;
        }

        return $this->_iPagination->getTheme();
    }

}
