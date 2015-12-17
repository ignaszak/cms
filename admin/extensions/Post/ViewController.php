<?php

namespace AdminController\Post;

use FrontController\Controller;
use Ignaszak\Registry\RegistryFactory;
use FrontController\ViewHelperController;

class ViewController extends Controller
{

    private $cms;

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
            public function getAdminViewPostList()
            {
                return get_class($this->_controller);
            }
        };
    }

}
