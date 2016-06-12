<?php
namespace View\Extension;

use Ignaszak\Registry\RegistryFactory;

class System
{

    /**
     *
     * @var \Conf\Conf
     */
    private $conf = null;

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $query = null;

    /**
     *
     * @var Ignaszak\Registry\Registry
     */
    private $registry = null;

    public function __construct()
    {
        $this->conf = RegistryFactory::start('file')
            ->register('Conf\Conf');
        $this->query = RegistryFactory::start()
            ->register('DataBase\Query\Query');
        $this->registry = RegistryFactory::start();
    }

    /**
     *
     * @return string
     */
    public function getSiteTitle(): string
    {
        return $this->conf->getSiteTitle();
    }

    /**
     *
     * @return string
     */
    public function getSiteDescription(): string
    {
        return $this->conf->getSiteDescription() ?? "";
    }

    /**
     *
     * @return string
     */
    public function getSiteAdress(): string
    {
        return $this->conf->getBaseUrl();
    }

    /**
     *
     * @return string
     */
    public function getThemeUrl(): string
    {
        return $this->conf->getBaseUrl() . '/app/' .
            $this->registry->get('view')->getThemeFolder();
    }

    /**
     *
     * @return integer
     */
    public function getViewLimit(): int
    {
        return $this->conf->getViewLimit();
    }

    /**
     * todo do something with paginate()
     * @return array
     */
    public function getResult(): array
    {
        return $this->query->getQuery();
    }

    /**
     *
     * @return string
     */
    public function getUserAccountLink(): string
    {
        return $this->registry->get('url')->url('user-account');
    }

    /**
     *
     * @return string
     */
    public function getAdminLink(): string
    {
        return $this->registry->get('url')->url('admin');
    }
}
