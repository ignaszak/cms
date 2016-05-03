<?php
namespace Pagination;

use Ignaszak\Registry\RegistryFactory;
use DataBase\Query\IQueryController;

class PaginationGenerator
{

    /**
     *
     * @var \Conf\Conf
     */
    private $conf = null;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http = null;

    /**
     *
     * @var \Ignaszak\Registry\RegistryFactory::start()
     */
    private $registry = null;

    /**
     * Posts limit
     *
     * @var integer
     */
    private $limit = 0;

    /**
     * Number of pages
     *
     * @var integer
     */
    private $countPage = 0;

    /**
     *
     * @var array
     */
    private $paginationArray = [];

    public function __construct()
    {
        $this->registry = RegistryFactory::start();
        $this->conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->http = $this->registry->get('http');
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
    public function getPrevLink(): string
    {
        return $this->paginationArray['prevLink'];
    }

    /**
     *
     * @return integer
     */
    public function getNextLink(): string
    {
        return $this->paginationArray['nextLink'];
    }

    /**
     * @return string
     */
    public function getPrevDisabled(): string
    {
        return $this->getCurrentPage() === 1 ? "disabled" : "";
    }

    /**
     *
     * @return string
     */
    public function getNextDisabled(): string
    {
        return $this->getCurrentPage() === $this->countPage ? "disabled" : "";
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
     *
     * @return integer
     */
    public function getCurrentPage(): int
    {
        $currentPage = $this->http->router->get('page');
        return empty($currentPage) ? 1 : $currentPage;
    }

    private function setParams()
    {
        $this->limit = $this->conf->getViewLimit();
        $this->countPage = $this->getSitesNumber();
    }

    /**
     * @return integer
     */
    private function getSitesNumber(): int
    {
        $sites = IQueryController::getCountQuery() / $this->limit;
        return ceil($sites);
    }

    private function createPaginationArray()
    {
        $paginationArray = [];
        for ($i = 0; $i < $this->countPage; ++ $i) {
            $paginationArray[$i] = [
                'number' => ($i + 1),
                'link' => $this->getLink($i + 1)
            ];
        }
        $currentPage = $this->getCurrentPage();
        $this->paginationArray = [
            'array' => $paginationArray,
            'prevLink' => $this->getLink(
                $currentPage === 1 ? 1 : $currentPage - 1
            ),
            'nextLink' => $this->getLink(
                $currentPage === $this->countPage ?
                    $currentPage : ($currentPage + 1)
            )
        ];
    }

    /**
     *
     * @param int $page
     * @return string
     */
    private function getLink(int $page): string
    {
        $tokens = $this->http->router->all();
        if (! empty($tokens['page'])) {
            unset($tokens['page']);
        }
        if (! empty($this->http->router->name())) {
            $name = $this->http->router->name() === 'default' ?
                'post-default' : $this->http->router->name();
        } else {
            $name = 'post-default';
        }
        return $this->registry->get('url')->url($name, array_merge($tokens, [
            'page' => $page
        ]));
    }
}
