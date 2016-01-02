<?php

namespace ViewHelper\Extension;

use Content\Query\Content as Query;
use Content\Query\IContentQueryController;

class Post
{

    /**
     * @var Query
     */
    private $_query;

    /**
     * @var \Entity\Posts[]
     */
    private $_post = array();

    /**
     * @var IContentQueryController
     */
    private $_postQuery;

    public function __construct()
    {
        $this->_query = new Query;
    }

    /**
     * @return boolean
     */
    public function havePost(): bool
    {
        $this->setPostFromDB();
        return count($this->_post);
    }

    /**
     * @return \Entity\Posts[]
     */
    public function getPosts(): array
    {
        if (empty($this->_post)) $this->setPostFromDB();
        return $this->_post;
    }

    /**
     * @return IContentQueryController
     */
    public function setPostQuery(): IContentQueryController
    {
        $this->_postQuery = $this->_query->setContent('post')
            ->force()
            ->paginate(false);

        return $this->_postQuery;
    }

    /**
     * @return array
     */
    public function getPostQuery(): array
    {
        return $this->_postQuery->getContent();
    }

    private function setPostFromDB()
    {
        $this->_query->setContent('post');
        $this->_post = $this->_query->getContent();
    }

}
