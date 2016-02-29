<?php
namespace AdminController\Menu;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;

class ViewMenuController extends FrontController
{

    public function run()
    {
        $this->view()->addView('theme/menu-view.html');
        $this->setViewHelperName('AdminViewMenu');
    }

    /**
     *
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class($this) extends ViewHelperController {

        public function getAdminViewMenu()
        {
            $this->_controller->query()->setQuery('menu')
                ->status('all');
            return $this->_controller->query()->getQuery();
        }

        public function getAdminViewMenuLink()
        {
            return $this->_controller->view()->getAdminAdress() . "/menu/";
        }
        };
    }
}
