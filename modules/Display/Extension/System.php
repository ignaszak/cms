<?php

namespace Display\Extension;

use Conf\Conf;
use Ignaszak\Registry\RegistryFactory;

class System
{

    private $_conf;

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
    }

    public function getSiteTitle()
    {
        return $this->_conf->getSiteTitle();
    }

    public function getSiteAdress()
    {
        return $this->_conf->getBaseUrl();
    }

    public function getThemePath()
    {
        return $this->_conf->getBaseUrl() . THEME_FOLDER;
    }

    public function getPageLimit()
    {
        return $this->_conf->getPostLimit();
    }

}
