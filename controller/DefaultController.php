<?php

namespace Controller;

use FrontController\Controller;

class DefaultController extends Controller
{

    public function run()
    {
        $this->_view->addView('post.html');
    }

}
