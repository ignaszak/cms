<?php
namespace AdminController\Page;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;

class ViewPageController extends FrontController
{

    public function run()
    {
        $this->view->addView('theme/page-view.html');
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
            public function getAdminPage(): array
            {
                $this->_controller->query->setQuery('page')->status('all');
                return $this->_controller->query->getQuery();
            }

            /**
             *
             * @param string $action
             * @param string $alias
             * @return string
             */
            public function getAdminPageLink(
                string $action,
                string $alias
            ): string {
                return $this->_controller->url('admin-page-edit', [
                    'action' => $action, 'alias' => $alias
                ]);
            }
        };
    }
}
