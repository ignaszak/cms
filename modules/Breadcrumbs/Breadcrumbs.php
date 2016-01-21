<?php
namespace Breadcrumbs;

class Breadcrumbs
{

    /**
     *
     * @var BreadcrumbsGenerator
     */
    private $_bg;

    public function __construct()
    {
        $this->_bg = new BreadcrumbsGenerator();
    }

    public function getCustomBreadcrumbs(): array
    {
        return $this->_bg->getBreadcrumbs();
    }

    public function getBreadcrumbsTheme(string $theme = "bootstrap"): string
    {
        switch ($theme) {
            case "bootstrap":
                $breadcrumbsTheme = new Theme\Bootstrap($this->_bg);
                break;
            case "arrows":
                $breadcrumbsTheme = new Theme\BreadcrumbsArrows($this->_bg);
                break;
            case "primary":
                $breadcrumbsTheme = new Theme\BreadcrumbsPrimary($this->_bg);
                break;
            default:
                $breadcrumbsTheme = new Theme\Bootstrap($this->_bg);
        }
        
        return $breadcrumbsTheme->getTheme();
    }
}
