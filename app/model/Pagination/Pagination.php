<?php
namespace Pagination;

class Pagination
{

    /**
     *
     * @var Theme\Theme
     */
    private $theme = null;

    /**
     *
     * @var PaginationGenerator
     */
    private $pg = null;

    public function __construct()
    {
        $this->pg = new PaginationGenerator();
    }

    /**
     *
     * @return \Pagination\PaginationGenerator
     */
    public function customPagination(): PaginationGenerator
    {
        return $this->pg;
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
                $this->theme = new Theme\MultiPage($this->pg);
                break;
            case "pager":
                $this->theme = new Theme\Pager($this->pg);
                break;
            case "pager-align":
                $this->theme = new Theme\PagerAlign($this->pg);
                break;
        }

        return $this->theme->getTheme();
    }
}
