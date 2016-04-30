<?php
namespace AdminController\Menu;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;

class EditMenuController extends FrontController
{

    public function run()
    {
        $this->view->addView('theme/menu-edit.html');
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
             * @var integer
             */
            private $id = null;

            /**
             *
             * @param FrontController $_controller
             */
            public function __construct(FrontController $_controller)
            {
                parent::__construct($_controller);
                $this->id = $this->_controller->http->router->get('id', 0);
            }

            /**
             *
             * @return string
             */
            public function getAdminLoadMenuFormTitle(): string
            {
                return $this->_controller->http->router->get('action') == 'edit' ?
                    "Edit menu" : "Create new menu";
            }

            /**
             *
             * @return integer
             */
            public function getAdminLoadMenuId(): int
            {
                return $this->id;
            }

            /**
             *
             * @return string
             */
            public function getAdminLoadMenuName(): string
            {
                $this->_controller->query->setQuery('menu')
                    ->id($this->id)
                    ->limit(1);
                $content = $this->_controller->query->getStaticQuery();
                return count($content) ? $content[0]->getName() : "";
            }

            /**
             *
             * @return string
             */
            public function getAdminLoadMenuLink(): string
            {
                return $this->id ?
                    "{$this->_controller->view->getAdminAdress()}/menu/ajax/{$this->id}/edit.json" : '';
            }

            /**
             *
             * @return string
             */
            public function getAdminLoadMenuDelete(): string
            {
                return "{$this->_controller->view->getAdminAdress()}/menu/delete/{$this->id}";
            }
        };
    }
}
