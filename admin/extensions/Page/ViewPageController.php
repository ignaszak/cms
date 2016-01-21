<?php
namespace AdminController\Page;

use FrontController\Controller;
use FrontController\ViewHelperController;

class ViewPageController extends Controller
{

    public function run()
    {
        $this->setViewHelperName('AdminViewPage');
        $this->view()->addView('theme/page-view.html');
    }

    /**
     *
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class($this) extends ViewHelperController {

        public function getAdminViewPage()
        {
            $this->_controller->query()
                ->setContent('page')
                ->status('all');
            return $this->_controller->query()->getContent();
        }

        public function getAdminViewPageLink()
        {
            return $this->_controller->view()->getAdminAdress() . "/page/";
        }
        };
    }
}
