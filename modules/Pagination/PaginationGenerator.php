<?php
namespace Pagination;

use System\Server;
use System\Router\Storage as Router;
use Content\Query\IContentQueryController as Content;
use Ignaszak\Registry\RegistryFactory;

class PaginationGenerator
{

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     * Posts limit
     *
     * @var integer
     */
    private $limit;

    /**
     * Number of pages
     *
     * @var integer
     */
    private $countPage;

    /**
     *
     * @var array
     */
    private $paginationArray = [];

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->setParams();
        $this->createPaginationArray();
    }

    /**
     * @return array
     */
    public function getPaginationArray(): array
    {
        return $this->paginationArray['array'];
    }

    /**
     *
     * @return integer
     */
    public function getPrevLink(): int
    {
        return $this->paginationArray['prevLink'];
    }

    /**
     *
     * @return integer
     */
    public function getNextLink(): int
    {
        return $this->paginationArray['nextLink'];
    }

    /**
     * @return string
     */
    public function getPrevDisabled(): string
    {
        return $this->getCurrentPage() == 1 ? "disabled" : "";
    }

    /**
     *
     * @return string
     */
    public function getNextDisabled(): string
    {
        return $this->getCurrentPage() == $this->countPage ? "disabled" : "";
    }

    /**
     *
     * @return integer
     */
    public function getCountPage(): int
    {
        return $this->countPage;
    }

    /**
     * @return string
     */
    public function getLinkWhitoutPage(): string
    {
        $requestWithoutFirstSlsh = preg_replace(
            '/^\//',
            '',
            Server::getHttpRequest()
        );
        $request = empty($requestWithoutFirstSlsh) ?
            Router::getDefaultRoute() . '/' : $requestWithoutFirstSlsh;
        $link = $this->_conf->getBaseUrl() . $request;
        return preg_replace('/([0-9]*)$/', '', $link);
    }

    /**
     *
     * @return integer
     */
    public function getCurrentPage(): int
    {
        $currentPage = Router::getRoute('page');
        return (empty($currentPage) ? 1 : $currentPage);
    }

    private function setParams()
    {
        $this->limit = $this->_conf->getViewLimit();
        $this->countPage = $this->getSitesNumber();
    }

    /**
     * @return integer
     */
    private function getSitesNumber(): int
    {
        $sites = Content::getCountQuery() / $this->limit;
        return ceil($sites);
    }

    private function createPaginationArray()
    {
        $paginationArray = array();

        for ($i = 0; $i < $this->countPage; ++ $i) {
            $paginationArray[$i] = array(
                'number' => ($i + 1),
                'link' => $this->getLinkWhitoutPage() . ($i + 1)
            );
        }

        $currentPage = $this->getCurrentPage();
        $prevLink = ($currentPage == 1 ? 1 : $currentPage - 1);
        $nextLink = ($currentPage == $this->countPage ? $currentPage : ($currentPage + 1));

        $this->paginationArray = [
            'array' => $paginationArray,
            'prevLink' => $prevLink,
            'nextLink' => $nextLink
        ];
    }
}
