<?php
namespace Entity\Controller;

use System\Router\Storage as Router;
use Ignaszak\Registry\RegistryFactory;
use Format\TextFormat;

abstract class IPostsQuery
{

    /**
     *
     * @var boolean
     */
    private $showAllText = false;

    abstract public function getId();

    abstract public function getDate($format = "");

    abstract public function getTitle();

    abstract public function getAlias();

    abstract public function getContent();

    abstract public function getPublic();

    abstract public function getAuthor();

    abstract public function getCategory();

    /**
     *
     * @return string
     */
    public function getLink()
    {
        $_conf = RegistryFactory::start()->register('\\Conf\\Conf');
        ;
        return "{$_conf->getBaseUrl()}post/{$this->getAlias()}";
    }

    /**
     *
     * @return string
     */
    public function getCategoryLink()
    {
        $_conf = RegistryFactory::start()->register('\\Conf\\Conf');
        ;
        return "{$_conf->getBaseUrl()}category/{$this->getCategory()->getAlias()}";
    }

    /**
     *
     * @return string
     */
    public function getDateLink($format = 'Y-m-d')
    {
        $_conf = RegistryFactory::start()->register('\\Conf\\Conf');
        ;
        return "{$_conf->getBaseUrl()}date/{$this->getDate($format)}";
    }

    /**
     *
     * @param int $cut
     * @return string
     */
    public function getText($cut = 500)
    {
        if (Router::getRoute('route1') == 'post' || ! $cut || $this->showAllText) {
            return $this->getContent();
        } else {
            return (new TextFormat())->truncateHtml($this->getContent(), $cut, "...") . $this->getMoreLink();
        }
    }

    public function showAllText()
    {
        $this->showAllText = true;
    }

    /**
     *
     * @return string
     */
    private function getMoreLink()
    {
        return "<a href=\"{$this->getLink()}\">Read more</a>";
    }
}
