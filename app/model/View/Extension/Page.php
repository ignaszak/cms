<?php
namespace View\Extension;

use Ignaszak\Registry\RegistryFactory;

class Page
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $query = null;

    /**
     *
     * @var \Entity\Pages[]
     */
    private $page = [];

    public function __construct()
    {
        $this->query = RegistryFactory::start()->register('DataBase\Query\Query');
    }

    /**
     *
     * @return boolean
     */
    public function havePage(): bool
    {
        $this->setPageFromDB();
        return array_key_exists(0, $this->page);
    }

    /**
     *
     * @return \Entity\Pages
     */
    public function getPage(): \Entity\Pages
    {
        if (empty($this->page)) {
            $this->setPageFromDB();
        }
        return (array_key_exists(0, $this->page)) ? $this->page[0] : new \Entity\Pages();
    }

    /**
     *
     * @return \Entity\Pages[]
     */
    public function getPages(): array
    {
        $this->query->setQuery('page')->paginate(true);
        return $this->query->getStaticQuery();
    }

    private function setPageFromDB()
    {
        $this->query->setQuery('page');
        $this->page = $this->query->getQuery();
    }
}
