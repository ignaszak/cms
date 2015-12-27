<?php

namespace Breadcrumbs\Theme;

use Breadcrumbs\BreadcrumbsGenerator;

class BreadcrumbsPrimary implements Theme
{

    /**
     * @var BreadcrumbsGenerator
     */
    private $_bg;

    /**
     * @param BreadcrumbsGenerator $_bg
     */
    public function __construct(BreadcrumbsGenerator $_bg)
    {
        $this->_bg = $_bg;
    }

    /**
     * {@inheritDoc}
     * @see \Breadcrumbs\Theme\Theme::getTheme()
     */
    public function getTheme(): string
    {
        $breadcrum = "<ol class=\"breadcrumb breadcrumb-arrow\">";
        $categories = $this->_bg->getBreadcrumbs();
        $i = 1;
        $count = count($categories);
        foreach ($categories as $cat) {
            if ($cat['title'] == 'Home') $cat['title'] = "<i class=\"glyphicon glyphicon-home\"></i>";
            if ($i == $count) { // Last element
                $breadcrum .= "<li class=\"active\">{$cat['title']}</li>";
            } else {
                $breadcrum .= "<li><a href=\"{$cat['link']}\">{$cat['title']}</a></li>";
            }
            ++$i;
        }
        $breadcrum .= "</ol>";

        return count($categories) ? $breadcrum : "";
    }

}