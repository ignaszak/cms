<?php
namespace AdminController\Menu;

use FrontController\Controller;
use FrontController\ViewHelperController;

class ViewMenuController extends Controller
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
            $this->_controller->query()
                ->setContent('menu')
                ->status('all');
            return $this->_controller->query()->getContent();
        }

        public function getAdminViewMenuLink()
        {
            return $this->_controller->view()->getAdminAdress() . "/menu/";
        }
        };
    }
}
