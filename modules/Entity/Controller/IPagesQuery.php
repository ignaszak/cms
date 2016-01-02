<?php

namespace Entity\Controller;

use Ignaszak\Registry\RegistryFactory;

abstract class IPagesQuery
{

    abstract public function getId();
    abstract public function getAuthorId();
    abstract public function getDate($format = "");
    abstract public function getTitle();
    abstract public function getAlias();
    abstract public function getContent();
    abstract public function getPublic();
    abstract public function getAuthor();

    /**
     * @return string
     */
    public function getLink()
    {
        $_conf = RegistryFactory::start()->register('Conf\Conf');
        return "{$_conf->getBaseUrl()}page/{$this->getAlias()}";
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->getContent();
    }

}
