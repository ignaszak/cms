<?php
namespace AdminController\Post;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;

class ViewPostController extends FrontController
{

    public function run()
    {
        $this->view->addView('theme/post-view.html');
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
            public function getAdminPostList(): array
            {
                $this->controller->query->setQuery('post')->status('all');
                return $this->controller->query->getQuery();
            }

            /**
             *
             * @param string $action
             * @param string $alias
             * @return string
             */
            public function getAdminPostLink(
                string $action,
                string $alias
            ): string {
                return $this->controller->url('admin-post-edit', [
                    'action' => $action, 'alias' => $alias
                ]);
            }
        };
    }
}
