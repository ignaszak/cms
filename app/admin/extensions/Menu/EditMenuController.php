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
             * @param FrontController $controller
             */
            public function __construct(FrontController $controller)
            {
                parent::__construct($controller);
                $this->id = $this->controller->http->router->get('id', 0);
            }

            /**
             *
             * @return string
             */
            public function getAdminLoadMenuFormTitle(): string
            {
                return $this->controller->http->router->get('action') === 'edit' ?
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
                $this->controller->query->setQuery('menu')
                    ->id($this->id)
                    ->limit(1);
                $content = $this->controller->query->getStaticQuery();
                return count($content) ? $content[0]->getName() : "";
            }

            /**
             *
             * @return string
             */
            public function getAdminLoadMenuLink(): string
            {
                return $this->id ? $this->controller->url(
                    'admin-menu-ajax-edit',
                    ['id' => $this->id]
                ) : '';
            }

            /**
             *
             * @return string
             */
            public function getAdminLoadMenuDelete(): string
            {
                return $this->controller->url('admin-menu-delete', [
                    'action' => 'delete', 'id' => $this->id
                ]);
            }
        };
    }
}
