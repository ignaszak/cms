<?php

namespace AdminController\Menu;

use FrontController\Controller;

class EditMenuController extends Controller
{

    public function run()
    {
        $this->_view->addView('theme/menu-edit.html');
    }

}
