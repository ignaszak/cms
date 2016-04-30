<?php
namespace AdminController\Page;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;
use DataBase\Controller\Controller;
use Entity\Pages;
use App\Resource\Server;

class EditPageController extends FrontController
{

    /**
     *
     * @var string
     */
    public $action;

    /**
     *
     * @var string
     */
    public $alias;

    public function run()
    {
        $this->action = $this->http->router->get('action');
        $this->alias = $this->http->router->get('alias');
        $this->view->addView('theme/page-edit.html');

        if ($this->action == 'delete' && $this->alias) {
            $controller = new Controller(new Pages());
            $controller->findOneBy([
                'alias' => $this->alias
            ])->remove();

            Server::headerLocation(
                $this->url('admin-page-list', [
                    'action' => 'view', 'page' => 1
                ])
            );
        }
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
             * @var array
             */
            private $returnData = [];

            /**
             *
             * @var array
             */
            private $data = [];

            /**
             *
             * @param FrontController $_controller
             */
            public function __construct(FrontController $_controller)
            {
                parent::__construct($_controller);
                $this->returnData = $this->_controller->view
                    ->getFormResponseData('data');
                $this->setData();
            }

            /**
             *
             * @param string $key
             * @return mixed
             */
            public function getAdminPage(string $key)
            {
                return $this->data[$key] ?? null;
            }

            private function setData()
            {
                $data = [];
                $data['id'] = null;
                $data['title'] = $this->returnData['setTitle'];
                $data['content'] = $this->returnData['setContent'];
                $data['public'] = $this->returnData['setPublic'];
                $data['formTitle'] = 'Add new page';
                $data['formLink'] = $this->_controller->url('admin-page-save', [
                    'action' => 'save'
                ]);

                if ($this->_controller->action == 'edit' && $this->_controller->alias) {

                    $data['formTitle'] = 'Edit page';

                    $this->_controller->query->setQuery('page')
                    ->alias($this->_controller->alias);

                    foreach ($this->_controller->query->getQuery() as $page) {
                        $data['id'] = $page->getId();
                        $data['title'] = $page->getTitle();
                        $data['content'] = $page->getContent();
                        $data['public'] = $page->getPublic();
                        $data['deleteLink'] = $this->_controller->url(
                            'admin-page-edit',
                            ['action' => 'delete', 'alias' => $page->getAlias()]
                            );
                    }
                }
                $this->data = $data;
            }
        };
    }
}
