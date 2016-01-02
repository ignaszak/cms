<?php

namespace ViewHelper\Extension;

use Content\Query\Content as Query;

class Page
{

    /**
     * @var Query
     */
    private $_query;

    /**
     * @var \Entity\Pages[0]
     */
    private $_page;

    public function __construct()
    {
        $this->_query = new Query;
    }

    /**
     * @return boolean
     */
    public function havePage(): bool
    {
        $this->setPageFromDB();
        return array_key_exists(0, $this->_page);
    }

    /**
     * @return \Entity\Pages
     */
    public function getPage(): \Entity\Pages
    {
        if (empty($this->_page)) $this->setPageFromDB();
        return (array_key_exists(0, $this->_page)) ?
            $this->_page[0] :
            new \Entity\Pages;
    }

    /**
     * @return \Entity\Pages[]
     */
    public function getPages(): array
    {
        $this->_query->setContent('page')->force();
        return $this->_query->getContent();
    }

    private function setPageFromDB()
    {
        $this->_query->setContent('page');
        $this->_page = $this->_query->getContent();
    }

}
