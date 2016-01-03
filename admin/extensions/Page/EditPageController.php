<?php

namespace AdminController\Page;

use FrontController\Controller;
use FrontController\ViewHelperController;

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
                $data['content'] = $this->returnData['setContent'];
                $data['public'] = $this->returnData['setPublic'];
                $data['formTitle'] = 'Add new page';
                $data['formLink'] = $this->_controller->getAdminAdress() . "/page/save";

                if ($this->_controller->getRoute('adminPageAction') == 'edit' &&
                    $this->_controller->getRoute('alias')) {

                        $data['formTitle'] = 'Edit page';

                        $this->_controller->setContent('page')
                            ->alias($this->_controller->getRoute('alias'));

                        foreach ($this->_controller->getContent() as $post) {
                            $data['id'] = $post->getId();
                            $data['title'] = $post->getTitle();
                            $data['content'] = $post->getContent();
                            $data['public'] = $post->getPublic();
                            $data['deleteLink'] = $this->_controller->getAdminAdress() .
                                "/page/delete" . $post->getAlias();
                        }

                    }

                    return @$data[$key];
            }
        };
    }

}
