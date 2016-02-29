<?php
namespace ViewHelper\Extension;

use Conf\Conf;
use Ignaszak\Registry\RegistryFactory;

class System
{

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $_query;

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')
            ->register('Conf\Conf');
        $this->_query = RegistryFactory::start()
            ->register('DataBase\Query\Query');
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
        return $this->_conf->getBaseUrl() . 'app/' .
            RegistryFactory::start()->get('view')->getThemeFolder();
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
     * todo do something with paginate()
     * @return array
     */
    public function getResult(): array
    {
        return $this->_query->getQuery();
    }
}
