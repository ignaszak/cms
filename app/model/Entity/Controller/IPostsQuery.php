<?php
namespace Entity\Controller;

use Format\TextFormat;
use Ignaszak\Registry\RegistryFactory;

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
        return RegistryFactory::start()->get('url')->url('post-alias', [
            'alias' => $this->getAlias(),
            'year' => $this->getDate('Y'),
            'month' => $this->getDate('m'),
            'day' => $this->getDate('d'),
            's1' => '/',
            's2' => '/'
        ]);
    }

    /**
     *
     * @return string
     */
    public function getCategoryLink()
    {
        return RegistryFactory::start()->get('url')->url('category-alias', [
            'alias' => $this->getCategory()->getAlias(), 'page' => 1
        ]);
    }

    /**
     *
     * @return string
     */
    public function getDateLink()
    {
        return RegistryFactory::start()->get('url')->url('date', [
            'year' => $this->getDate('Y'),
            'month' => $this->getDate('m'),
            'day' => $this->getDate('d'),
            's1' => '/',
            's2' => '/',
            'page' => 1
        ]);
    }

    /**
     *
     * @param int $cut
     * @return string
     */
    public function getText($cut = 500)
    {
        if ($this->isPostOpen() || ! $cut || $this->showAllText) {
            return $this->getContent();
        } else {
            $textFormat = new TextFormat();
            return $textFormat->truncateHtml(
                $this->getContent(),
                $cut,
                "..."
            ) . $this->getMoreLink();
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

    /**
     * @return boolean
     */
    private function isPostOpen()
    {
        return RegistryFactory::start()->get('http')
            ->router->name() === 'post-alias';
    }
}
