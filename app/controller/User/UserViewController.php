<?php
namespace Controller\User;

use FrontController\Controller as FrontController;

class UserViewController extends FrontController
{

    public function run()
    {
        $this->view->addView('user.html');
    }
}
