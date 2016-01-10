<?php

namespace Controller;

use FrontController\Controller;

class UserAuthController extends Controller
{

    public function run()
    {
        $this->_view->addView('user.html');
    }

}
