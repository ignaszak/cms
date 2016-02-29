<?php
namespace Controller;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;
use App\Resource\Server;

class SearchController extends FrontController
{
    /**
     *
     * @var string
     */
    public $search;

    public function run()
    {
        $this->setSearch();
        $this->setSearchToReferData();
        $this->setViewHelperName('Search');
        $this->view()->addView('search.html');
    }

    /**
     *
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class($this) extends ViewHelperController
        {

        public function getSearchFor()
        {
            return $this->_controller->search;
        }

        public function getSearchResult(): array
        {
            $this->_controller->query()
                ->setQuery('post')
                ->query(
                    "c.title LIKE :search OR
                            c.content LIKE :search",
                    [':search' => "%{$this->_controller->search}%"]
                )
                ->paginate(true);
            return $this->_controller->query()->getStaticQuery();
        }
        };
    }

    private function setSearch()
    {
        if (!empty($_POST['search'])) {
            $this->search = $_POST['search'];
        } else {
            $this->search = Server::getReferData()['search'];
        }
    }

    private function setSearchToReferData()
    {
        Server::setReferData([
            'search' => $this->search
        ]);
        Server::setRefererSession();
    }
}
