<?php

namespace Display\Extension;

use Conf\Conf;
use Display\Extension\Content\IContentQuery;

class Pagination
{

    private $_conf;
    private $limit;
    private $countSite;
    private $paginationArray = array();

    public function __construct()
    {
        $this->_conf = Conf::instance();
        $this->setParams();
        $this->createPaginationArray();
    }

    public function getPagination()
    {
        return $this->paginationArray['array'];
    }

    public function getPaginationPrevLink()
    {
        return $this->paginationArray['prevLink'];
    }

    public function getPaginationNextLink()
    {
        return $this->paginationArray['nextLink'];
    }

    public function getPaginationTheme($theme = "pagination")
    {
        if ($this->countSite > 1) {

            $siteCount = $this->countSite;
            $currentPage = $this->getCurrentPage();
            $paginationPage = '';

            foreach ($this->paginationArray['array'] as $page) {
                $class = ($page['number'] == $currentPage ? 'active' : ''); 
                $paginationPage .= "<li class=\"$class\"><a href=\"{$page['link']}\">{$page['number']}</a></li>";
            }

            $prevDisabledClass = '';
            $nextDisabledClass = '';

            if ($currentPage == 1) {
                $prevDisabledClass = 'disabled';
            } elseif ($currentPage == $siteCount) {
                $nextDisabledClass = 'disabled';
            }

            $prev = $this->paginationArray['prevLink'];
            $next = $this->paginationArray['nextLink'];
            $link = $this->getLinkWhitoutPage();

            if ($theme == "pagination") {

                $pagination = "
                    <nav>
                        <ul class=\"$theme\">
                            <li class=\"$prevDisabledClass\">
                                <a href=\"".$link.$prev."\" aria-label=\"Previous\">
                                    <span aria-hidden=\"true\">&laquo;</span>
                                </a>
                            </li>
                ";
                $pagination .= $paginationPage;
                $pagination .= "
                            <li class=\"$nextDisabledClass\">
                                <a href=\"".$link.$next."\" aria-label=\"Next\">
                                    <span aria-hidden=\"true\">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                ";

            } elseif ($theme == "pager") {

                $pagination = "
                    <nav>
                        <ul class=\"pager\">
                            <li class=\"$prevDisabledClass\"><a href=\"".$link.$prev."\">Previous</a></li>
                            <li class=\"$nextDisabledClass\"><a href=\"".$link.$next."\">Next</a></li>
                        </ul>
                    </nav>
                ";

            } elseif ($theme == "pager-align") {

                $pagination = "
                    <nav>
                        <ul class=\"pager\">
                            <li class=\"previous $nextDisabledClass\"><a href=\"".$link.$next."\"><span aria-hidden=\"true\">&larr;</span> Older</a></li>
                            <li class=\"next $prevDisabledClass\"><a href=\"".$link.$prev."\">Newer <span aria-hidden=\"true\">&rarr;</span></a></li>
                        </ul>
                    </nav>
                ";

            }

            return $pagination;

        }
    }

    private function setParams()
    {
        $this->limit = $this->_conf->getPostLimit();
        $this->countSite = $this->getSitesNumber();
    }

    private function getSitesNumber()
    {
        $sites = IContentQuery::getCountQuery() / $this->limit;
        return ceil($sites);
    }

    private function createPaginationArray()
    {
        $paginationArray = array();

        for ($i=0; $i<$this->countSite; ++$i) {
            $paginationArray[$i] = array(
                'number' => ($i + 1),
                'link' => $this->getLinkWhitoutPage() . ($i + 1)
            );
        }

        $siteCount = $this->countSite;
        $currentPage = $this->getCurrentPage();
        $prev = ($currentPage == 1 ? 1 : $currentPage - 1);
        $next = ($currentPage == $siteCount ? $currentPage : ($currentPage + 1));

        $this->paginationArray['array'] = $paginationArray;
        $this->paginationArray['prevLink'] = $prev;
        $this->paginationArray['nextLink'] = $next;
    }

    private function getLinkWhitoutPage()
    {
        $request = \System\System::getHttpRequest();
        $request = (empty($request) ? $request . \Ignaszak\Router\Client::getDefaultRoute() . '/' : $request);
        $link = $this->_conf->getBaseUrl() . $request;
        return preg_replace('/([0-9]*)$/', '', $link);
    }

    private function getCurrentPage()
    {
        $currentPage = \Ignaszak\Router\Client::getRoute('page');

        return (empty($currentPage) ? 1 : $currentPage);
    }

}
