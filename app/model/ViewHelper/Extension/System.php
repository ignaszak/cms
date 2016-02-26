<?php
namespace ViewHelper\Extension;

use Conf\Conf;
use Ignaszak\Registry\RegistryFactory;
use Content\Query\IContentQueryController;

class System
{

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     *
     * @var \Content\Query\Content
     */
    private $_query;

    private $_setQuery;

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')
            ->register('Conf\Conf');
        $this->_query = RegistryFactory::start()
            ->register('Content\Query\Content');
    }

    /**
     *
     * @return string
     */
    public function getSiteTitle(): string
    {
        return $this->_conf->getSiteTitle();
    }

    /**
     *
     * @return string
     */
    public function getSiteDescription(): string
    {
        return $this->_conf->getSiteDescription() ?? "";
    }

    /**
     *
     * @return string
     */
    public function getSiteAdress(): string
    {
        return $this->_conf->getBaseUrl();
    }

    /**
     *
     * @return string
     */
    public function getThemeUrl(): string
    {
        return $this->_conf->getBaseUrl() . RegistryFactory::start()->get('view')->getThemeFolder();
    }

    /**
     *
     * @return integer
     */
    public function getViewLimit(): int
    {
        return $this->_conf->getViewLimit();
    }

    /**
     *
     * @param string $table
     * @return IContentQueryController
     */
    public function setQuery(string $table): IContentQueryController
    {
        $this->_setQuery = $this->_query->setContent($table)
            ->force()
            ->paginate(false);

        return $this->_setQuery;
    }

    /**
     *
     * @return array
     */
    public function getResult(): array
    {
        return $this->_setQuery->getContent();
    }

    /**
     *
     * @return Entity
     */
    public function getSingleResult()
    {
        return $this->_setQuery->getContent()[0];
    }
}
