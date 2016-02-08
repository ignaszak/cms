<?php
namespace AdminController\Page;

use FrontController\Controller;
use FrontController\ViewHelperController;
use Content\Controller\Factory;
use Content\Controller\PageController;
use System\Server;

class EditPageController extends Controller
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
            $controller = new Factory(new PageController());
            $controller->findOneBy(array(
                'alias' => $this->alias
            ))->remove();

            Server::headerLocation("admin/page/view/");
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

        public function __construct(Controller $_controller)
        {
            parent::__construct($_controller);
            $this->returnData = $this->_controller->view()
                ->getFormResponseData('data');
        }

        public function getAdminEditPage(string $key)
        {
            $data = array();

            $data['id'] = null;
            $data['title'] = $this->returnData['setTitle'];
            $data['content'] = $this->returnData['setContent'];
            $data['public'] = $this->returnData['setPublic'];
            $data['formTitle'] = 'Add new page';
            $data['formLink'] = $this->_controller->view()->getAdminAdress() . "/page/save";

            if ($this->_controller->action == 'edit' && $this->_controller->alias) {

                $data['formTitle'] = 'Edit page';

                $this->_controller->query()
                    ->setContent('page')
                    ->alias($this->_controller->alias);

                foreach ($this->_controller->query()->getContent() as $post) {
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
