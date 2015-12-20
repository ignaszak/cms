<?php

namespace AdminController\Post;

use FrontController\Controller;
use System\Server;
use Ignaszak\Registry\RegistryFactory;
use FrontController\ViewHelperController;
use Content\Controller\Factory;
use Content\Controller\PostController;

class EditController extends Controller
{

    public $cms;

    public function __construct()
    {
        $this->cms = RegistryFactory::start()->get('cms');
    }

    public function run()
    {
        $this->setViewHelperName('AdminEditPost');

        if ($this->cms->getRoute('adminPostAction') == 'delete' && $this->cms->getRoute('alias')) {
            // Initialize
            $controller = new Factory(new PostController);
            // Find
            $controller->findBy(
                array('alias' => $this->cms->getRoute('alias'))
            );
            // Execute
            $controller->remove();

            Server::headerLocation("admin/post/view/");
        }
    }

    /**
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class ($this) extends ViewHelperController
        {

            private $cms;
            private $returnData;

            public function __construct(Controller $_controller)
            {
                parent::__construct($_controller);
                $this->cms = $this->_controller->cms;
                $this->returnData = $this->cms->getFormResponseData('data');
            }

            public function getAdminEditPost(string $key)
            {
                $data = array();

                $data['id'] = null;
                $data['title'] = $this->returnData['setTitle'];
                $data['conten'] = $this->returnData['setContent'];
                $data['catId'] = $this->returnData['setCategory'];
                $data['public'] = $this->returnData['setPublic'];
                $data['formTitle'] = 'Add new post';
                $data['formLink'] = $this->cms->getAdminAdress() . "/post/form";

                if ($this->cms->getRoute('adminPostAction') == 'edit') {

                    $data['formTitle'] = 'Edit post';

                    $this->cms->setContent('post')
                        ->alias($this->cms->getRoute('alias'));

                    foreach ($this->cms->getContent() as $post) {
                        $data['id'] = $post->getId();
                        $data['catId'] = $post->getCategoryId();
                        $data['title'] = $post->getTitle();
                        $data['content'] = $post->getContent();
                        $data['public'] = $post->getPublic();
                        $data['deleteLink'] = $this->cms->getAdminAdress() . "/post/delete/" . $post->getAlias();
                    }

                }

                return @$data[$key];
            }
        };
    }

}
