<?php

namespace Pagination;

use System\Server;
use System\Router\Storage as Router;
use Content\Query\IContentQueryController as Content;
use Ignaszak\Registry\RegistryFactory;

class PaginationGenerator
{

    private $_conf;
    private $limit;
    private $countSite;
    private $paginationArray = array();

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->setParams();
        $this->createPaginationArray();
    }

    public function getPaginationArray()
    {
        return $this->paginationArray['array'];
    }

    public function getPrevLink()
    {
        return $this->paginationArray['prevLink'];
    }

    public function getNextLink()
    {
        return $this->paginationArray['nextLink'];
    }

    public function getPrevDisabled()
    {
        return $this->getCurrentPage() == 1 ? "disabled" : "";
    }

    public function getNextDisabled()
    {
        return $this->getCurrentPage() == $this->countSite ? "disabled" : "";
    }

    public function getCountSite()
    {
        return $this->countSite;
    }

    public function getLinkWhitoutPage()
    {
        $request = Server::getHttpRequest();
        $request = (empty($request) ? $request . Router::getDefaultRoute() . '/' : $request);
        $link = $this->_conf->getBaseUrl() . $request;
        return preg_replace('/([0-9]*)$/', '', $link);
    }

    public function getCurrentPage()
    {
        $currentPage = Router::getRoute('page');
        return (empty($currentPage) ? 1 : $currentPage);
    }

    private function setParams()
    {
        $this->limit = $this->_conf->getViewLimit();
        $this->countSite = $this->getSitesNumber();
    }

    private function getSitesNumber()
    {
        $sites = Content::getCountQuery() / $this->limit;
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

        $currentPage = $this->getCurrentPage();
        $prevLink = ($currentPage == 1 ? 1 : $currentPage - 1);
        $nextLink = ($currentPage == $this->countSite ? $currentPage : ($currentPage + 1));
    
        $this->paginationArray['array'] = $paginationArray;
        $this->paginationArray['prevLink'] = $prevLink;
        $this->paginationArray['nextLink'] = $nextLink;
    }

}
