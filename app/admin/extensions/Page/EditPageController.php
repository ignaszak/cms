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
        $this->action = $this->view()->getRoute('action');
        $this->alias = $this->view()->getRoute('alias');

        $this->setViewHelperName('AdminEditPage');
        $this->view()->addView('theme/page-edit.html');

        if ($this->action == 'delete' && $this->alias) {
            $controller = new Controller(new Pages());
            $controller->findOneBy([
                'alias' => $this->alias
            ])->remove();

            Server::headerLocation("/admin/page/view/");
        }
    }

    /**
     *
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class($this) extends ViewHelperController {

        private $returnData;

        public function __construct(FrontController $_controller)
        {
            parent::__construct($_controller);
            $this->returnData = $this->_controller->view()
                ->getFormResponseData('data');
        }

        public function getAdminEditPage(string $key)
        {
            $data = [];

            $data['id'] = null;
            $data['title'] = $this->returnData['setTitle'];
            $data['content'] = $this->returnData['setContent'];
            $data['public'] = $this->returnData['setPublic'];
            $data['formTitle'] = 'Add new page';
            $data['formLink'] = $this->_controller->view()->getAdminAdress() .
                "/page/save";

            if ($this->_controller->action == 'edit' && $this->_controller->alias) {

                $data['formTitle'] = 'Edit page';

                $this->_controller->query()->setQuery('page')
                    ->alias($this->_controller->alias);

                foreach ($this->_controller->query()->getQuery() as $post) {
                    $data['id'] = $post->getId();
                    $data['title'] = $post->getTitle();
                    $data['content'] = $post->getContent();
                    $data['public'] = $post->getPublic();
                    $data['deleteLink'] = "{$this->_controller->view()
                        ->getAdminAdress()}/page/delete{$post->getAlias()}";
                }
            }

            return @$data[$key];
        }
        };
    }
}
