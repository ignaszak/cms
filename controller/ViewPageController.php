<?php

namespace Controller;

use FrontController\Controller;

class ViewPageController extends Controller
{

    public function run()
    {
        $this->_view->addView('page.html');
    }

}
