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
    public $search = '';

    public function run()
    {
        $this->setSearch();
        $this->setSearchToReferData();
        $this->view->addView('search.html');
    }

    /**
     *
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class($this) extends ViewHelperController
        {

            /**
             *
             * @return string
             */
            public function getSearchFor(): string
            {
                return $this->controller->search;
            }

            /**
             *
             * @return \DataBase\Query\Entity[]
             */
            public function getSearchResult(): array
            {
                $this->controller->query
                    ->setQuery('post')
                    ->query(
                        'c.title LIKE :search OR ' .
                        'c.content LIKE :search AND ' .
                        'c.public = 1',
                        [':search' => "%{$this->controller->search}%"]
                    )
                    ->paginate(true);
                return $this->controller->query->getStaticQuery();
            }
        };
    }

    private function setSearch()
    {
        $search = $this->http->request->get('search');
        if (!empty($search)) {
            $this->search = $search;
        } else {
            $this->search = Server::getReferData()['search'];
        }
    }

    private function setSearchToReferData()
    {
        Server::setReferData(
            [
                'search' => $this->search
            ]
        );
        Server::setRefererSession();
    }
}
