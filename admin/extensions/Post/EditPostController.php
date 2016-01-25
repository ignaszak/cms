<?php
namespace AdminController\Post;

use FrontController\Controller;
use System\Server;
use FrontController\ViewHelperController;
use Content\Controller\Factory;
use Content\Controller\PostController;

class EditPostController extends Controller
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
        $this->setViewHelperName('AdminEditPost');
        $this->view()->addView('theme/post-edit.html');

        if ($this->action == 'delete' && $this->alias) {
            $controller = new Factory(new PostController());
            $controller->findOneBy(array(
                'alias' => $this->alias
            ))->remove();

            Server::headerLocation("admin/post/p/view/");
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
            $this->returnData = $this->_controller->view()->getFormResponseData('data');
        }

        public function getAdminEditPost(string $key)
        {
            $data = array();

            $data['id'] = null;
            $data['title'] = $this->returnData['setTitle'];
            $data['content'] = $this->returnData['setContent'];
            $data['catId'] = $this->returnData['setCategory'];
            $data['public'] = $this->returnData['setPublic'];
            $data['formTitle'] = 'Add new post';
            $data['formLink'] = $this->_controller->view()->getAdminAdress() . "/post/p/form";

            if ($this->_controller->action == 'edit' && $this->_controller->alias) {

                $data['formTitle'] = 'Edit post';

                $this->_controller->query()
                    ->setContent('post')
                    ->alias($this->_controller->alias);

                foreach ($this->_controller->query()->getContent() as $post) {
                    $data['id'] = $post->getId();
                    $data['catId'] = $post->getCategory()->getId();
                    $data['title'] = $post->getTitle();
                    $data['content'] = $post->getContent();
                    $data['public'] = $post->getPublic();
                    $data['deleteLink'] = $this->_controller->view()->getAdminAdress() . "/post/p/delete/" . $post->getAlias();
                }
            }

            return @$data[$key];
        }
        };
    }
}
