<?php

namespace AdminController\Post;

use FrontController\Controller;
use Ignaszak\Registry\RegistryFactory;
use FrontController\ViewHelperController;

class ViewPostController extends Controller
{

    public $cms;

    public function __construct()
    {
        $this->cms = RegistryFactory::start()->get('cms');
    }

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
                $this->_controller->cms->setContent('post')->status('all');
                return $this->_controller->cms->getContent();
            }

            public function getAdminViewPostLink()
            {
                return $this->_controller->cms->getAdminAdress() . "/post/p/edit/";
            }
        };
    }

}
