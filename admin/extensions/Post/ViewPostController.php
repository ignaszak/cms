<?php

namespace AdminController\Post;

use FrontController\Controller;
use FrontController\ViewHelperController;

class ViewPostController extends Controller
{

    public function run()
    {
        $this->setViewHelperName('AdminViewPost');
    }

    /**
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class ($this) extends ViewHelperController
        {
            public function getAdminViewPost()
            {
                $this->_controller->setContent('post')->status('all');
                return $this->_controller->getContent();
            }

            public function getAdminViewPostLink()
            {
                return $this->_controller->getAdminAdress() . "/post/p/edit/";
            }
        };
    }

}
