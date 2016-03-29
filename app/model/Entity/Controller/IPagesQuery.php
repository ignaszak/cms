<?php
namespace Entity\Controller;

use App\Resource\RouterStatic as Router;

abstract class IPagesQuery
{

    abstract public function getDate($format = "");

    abstract public function getTitle();

    abstract public function getAlias();

    abstract public function getContent();

    abstract public function getPublic();

    abstract public function getAuthor();

    /**
     *
     * @return string
     */
    public function getLink()
    {
        return Router::getLink('page-alias', [
            'alias' => $this->getAlias()
        ]);
    }

    /**
     *
     * @return string
     */
    public function getText()
    {
        return $this->getContent();
    }
}
