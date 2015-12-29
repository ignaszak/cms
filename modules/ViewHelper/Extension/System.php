<?php

namespace ViewHelper\Extension;

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

    public function getThemeUrl()
    {
        return $this->_conf->getBaseUrl() . RegistryFactory::start()->get('view')->getThemeFolder();
    }

    public function getPageLimit()
    {
        return $this->_conf->getPostLimit();
    }

}
