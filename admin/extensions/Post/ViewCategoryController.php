<?php

namespace AdminController\Post;

use FrontController\Controller;

class ViewCategoryController extends Controller
{

    public function run()
    {
        $this->_view->addView('theme/category-view.html');
    }

}
