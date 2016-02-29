<?php
namespace AdminController\Post;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;

class ViewPostController extends FrontController
{

    public function run()
    {
        $this->setViewHelperName('AdminViewPost');
        $this->view()->addView('theme/post-view.html');
    }

    /**
     *
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class($this) extends ViewHelperController
        {

        public function getAdminViewPost()
        {
            $this->_controller->query()->setQuery('post')
                ->status('all');
            return $this->_controller->query()->getQuery();
        }

        public function getAdminViewPostLink()
        {
            return $this->_controller->view()->getAdminAdress() .
                "/post/p/edit/";
        }
        };
    }
}
