<?php
namespace Controller;

use FrontController\Controller as FrontController;

class ViewPageController extends FrontController
{

    public function run()
    {
        $this->view->addView('page.html');
    }
}
