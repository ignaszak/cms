<?php

namespace Controller\User;

use FrontController\Controller;

class UserViewController extends Controller
{

    public function run()
    {
        $this->_view->addView('user.html');
    }

}
