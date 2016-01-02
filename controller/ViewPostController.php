<?php

namespace Controller;

use FrontController\Controller;

class ViewPostController extends Controller
{

    public function run()
    {
        $this->_view->addView('post.html');
    }

}
