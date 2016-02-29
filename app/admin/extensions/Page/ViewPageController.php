<?php
namespace AdminController\Page;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;

class ViewPageController extends FrontController
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
            $this->_controller->query()->setQuery('page')
                ->status('all');
            return $this->_controller->query()->getQuery();
        }

        public function getAdminViewPageLink()
        {
            return $this->_controller->view()->getAdminAdress() . "/page/";
        }
        };
    }
}
