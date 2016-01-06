<?php

namespace AdminController\Menu;

use FrontController\Controller;
use System\Router\Storage as Router;
use FrontController\ViewHelperController;

class EditMenuController extends Controller
{

    public function run()
    {
        $this->_view->addView('theme/menu-edit.html');
        $this->setViewHelperName('AdminLoadMenu');
    }

    /**
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class ($this) extends ViewHelperController
        {
            private $id;

            public function __construct(Controller $_controller)
            {
                parent::__construct($_controller);
                $this->id = Router::getRoute('id');
            }

            public function getAdminLoadMenuId()
            {
                return empty($this->id) ? "" : $this->id;
            }

            public function getAdminLoadMenuName(): string
            {
                $this->_controller->view()->setContent('menu')
                    ->id($this->id)
                    ->limit(1)
                    ->paginate(false)
                    ->force();
                $content = $this->_controller->view()->getContent();
                return count($content) ? $content[0]->getName() : "";
            }

            public function getAdminLoadMenuLink(): string
            {
                return empty($this->id) ? "" :
                    $this->_controller->view()->getAdminAdress() . '/menu/ajax/' .
                    $this->id . '/edit.json';
            }
        };
    }

}
