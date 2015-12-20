<?php

namespace Entity\Controller;

use System\Router\Storage as Router;
use Ignaszak\Registry\RegistryFactory;
use Format\TextFormat;

abstract class IPostsQuery
{

    abstract public function getId();
    abstract public function getCategoryId();
    abstract public function getAuthorId();
    abstract public function getDate($format = "");
    abstract public function getTitle();
    abstract public function getAlias();
    abstract public function getContent();
    abstract public function getPublic();
    abstract public function getAuthor();
    abstract public function getCategory();

    /**
     * @return string
     */
    public function getLink()
    {
        $_cms = RegistryFactory::start()->get('cms');
        return "{$_cms->getSiteAdress()}post/{$this->getAlias()}";
    }

    /**
     * @param int $cut
     * @return string
     */
    public function getText($cut = 500)
    {
        if (!empty(Router::getRoute('alias')) || !$cut) {
            return $this->getContent();
        } else {
            return (new TextFormat)->truncateHtml(
                $this->getContent(),
                $cut,
                "..."
            ) . $this->getMoreLink();
        }
    }

    /**
     * @return string
     */
    private function getMoreLink()
    {
        return "<a href=\"{$this->getLink()}\">Read more</a>";
    }

}
