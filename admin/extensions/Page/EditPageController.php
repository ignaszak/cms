<?php

namespace AdminController\Page;

use FrontController\Controller;
use System\Server;
use FrontController\ViewHelperController;
use Content\Controller\Factory;
use Content\Controller\PostController;

class EditPageController extends Controller
{

    public function run()
    {
        $this->setViewHelperName('AdminEditPage');
        $this->_view->addView('theme/page-edit.html');
    }

    /**
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class ($this) extends ViewHelperController
        {

            private $returnData;

            public function __construct(Controller $_controller)
            {
                parent::__construct($_controller);
                $this->returnData = $this->_controller->getFormResponseData('data');
            }

            public function getAdminEditPage(string $key)
            {
                $data = array();

                $data['id'] = null;
                $data['title'] = $this->returnData['setTitle'];
                $data['conten'] = $this->returnData['setContent'];
                $data['catId'] = $this->returnData['setCategory'];
                $data['public'] = $this->returnData['setPublic'];
                $data['formTitle'] = 'Add new post';
                $data['formLink'] = $this->_controller->getAdminAdress() . "/post/p/form";

                if ($this->_controller->getRoute('adminPostAction') == 'edit' &&
                    $this->_controller->getRoute('alias')) {

                        $data['formTitle'] = 'Edit post';

                        $this->_controller->setContent('post')
                        ->alias($this->_controller->getRoute('alias'));

                        foreach ($this->_controller->getContent() as $post) {
                            $data['id'] = $post->getId();
                            $data['catId'] = $post->getCategoryId();
                            $data['title'] = $post->getTitle();
                            $data['content'] = $post->getContent();
                            $data['public'] = $post->getPublic();
                            $data['deleteLink'] = $this->_controller->getAdminAdress() .
                            "/post/p/delete/" . $post->getAlias();
                        }

                    }

                    return @$data[$key];
            }
        };
    }

}
