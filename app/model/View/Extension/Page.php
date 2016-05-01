<?php
namespace View\Extension;

use Ignaszak\Registry\RegistryFactory;

class Page
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $_query;

    /**
     *
     * @var \Entity\Pages[0]
     */
    private $_page;

    public function __construct()
    {
        $this->_query = RegistryFactory::start()->register('DataBase\Query\Query');
    }

    /**
     *
     * @return boolean
     */
    public function havePage(): bool
    {
        $this->setPageFromDB();
        return array_key_exists(0, $this->_page);
    }

    /**
     *
     * @return \Entity\Pages
     */
    public function getPage(): \Entity\Pages
    {
        if (empty($this->_page)) {
            $this->setPageFromDB();
        }
        return (array_key_exists(0, $this->_page)) ? $this->_page[0] : new \Entity\Pages();
    }

    /**
     *
     * @return \Entity\Pages[]
     */
    public function getPages(): array
    {
        $this->_query->setQuery('page')->paginate(true);
        return $this->_query->getStaticQuery();
    }

    private function setPageFromDB()
    {
        $this->_query->setQuery('page');
        $this->_page = $this->_query->getQuery();
    }
}
