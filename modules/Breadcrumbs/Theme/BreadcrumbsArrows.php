<?php
namespace Breadcrumbs\Theme;

use Breadcrumbs\BreadcrumbsGenerator;

class BreadcrumbsArrows implements Theme
{

    /**
     *
     * @var BreadcrumbsGenerator
     */
    private $_bg;

    /**
     *
     * @param BreadcrumbsGenerator $_bg
     */
    public function __construct(BreadcrumbsGenerator $_bg)
    {
        $this->_bg = $_bg;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Breadcrumbs\Theme\Theme::getTheme()
     */
    public function getTheme(): string
    {
        $breadcrum = "<div class=\"btn-group btn-breadcrumb\">";
        $categories = $this->_bg->getBreadcrumbs();
        foreach ($categories as $cat) {
            if ($cat['title'] == 'Home') {
                $cat['title'] = "<i class=\"glyphicon glyphicon-home\"></i>";
            }
            $breadcrum .= "<a href=\"{$cat['link']}\" class=\"btn btn-default\">{$cat['title']}</a>";
        }
        $breadcrum .= "</div>";
        
        return count($categories) ? $breadcrum : "";
    }
}
