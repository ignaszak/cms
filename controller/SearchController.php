<?php
namespace Controller;

use FrontController\Controller;
use FrontController\ViewHelperController;

class SearchController extends Controller
{

    public function run()
    {
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

        public function getSearchFor(): string
        {
            return $_POST['search'];
        }

        public function getSearchResult(): array
        {
            $this->_controller->query()
                ->setContent('post')
                ->force()
                ->query(
                    "c.title LIKE :search OR
                        c.content LIKE :search",
                    [':search' => "%{$_POST['search']}%"]
                );
            return $this->_controller->query()->getContent();
        }

        public function getAdminViewPostLink()
        {
            return $this->_controller->view()->getAdminAdress() . "/post/p/edit/";
        }
        };
    }
}
