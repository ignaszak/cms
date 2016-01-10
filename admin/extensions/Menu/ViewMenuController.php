<?php

namespace AdminController\Menu;

use FrontController\Controller;
use System\Router\Storage as Router;
use FrontController\ViewHelperController;

class ViewMenuController extends Controller
{

    public function run()
    {
        $this->_view->addView('theme/menu-view.html');
        $this->setViewHelperName('AdminViewMenu');
    }

    /**
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class ($this) extends ViewHelperController
        {
            public function getAdminViewMenu()
            {
                $this->_controller->setContent('menu')->status('all');
                return $this->_controller->getContent();
            }

            public function getAdminViewMenuLink()
            {
                return $this->_controller->getAdminAdress() . "/menu/";
            }
        };
    }

}
