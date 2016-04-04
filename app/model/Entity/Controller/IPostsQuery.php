<?php
namespace Entity\Controller;

use App\Resource\RouterStatic as Router;
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
        return Router::getLink('post-alias', [
            'alias' => $this->getAlias()
        ]);
    }

    /**
     *
     * @return string
     */
    public function getCategoryLink()
    {
        return Router::getLink('cat-alias', [
            'alias' => $this->getCategory()->getAlias()
        ]);
    }

    /**
     *
     * @return string
     */
    public function getDateLink()
    {
        return Router::getLink('date', [
            'year' => $this->getDate('Y'),
            'month' => $this->getDate('m'),
            'day' => $this->getDate('d'),
            's1' => '-',
            's2' => '-'
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
        return Router::getName() == 'post-alias';
    }
}
