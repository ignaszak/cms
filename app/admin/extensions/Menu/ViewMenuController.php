<?php
namespace AdminController\Menu;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;

class ViewMenuController extends FrontController
{

    public function run()
    {
        $this->view->addView('theme/menu-view.html');
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
             * @return array
             */
            public function getAdminMenuList(): array
            {
                $this->controller->query->setQuery('menu')->status('all');
                return $this->controller->query->getQuery();
            }

            /**
             *
             * @return string
             */
            public function getAdminMenuLink(string $action, int $id): string
            {
                return $this->controller->url("admin-menu-{$action}", [
                    'action' => $action, 'id' => $id
                ]);
            }
        };
    }
}
