<?php

namespace Controller\User;

use FrontController\Controller;

class UserViewController extends Controller
{

    public function run()
    {
        $this->view()->addView('user.html');
    }

}
