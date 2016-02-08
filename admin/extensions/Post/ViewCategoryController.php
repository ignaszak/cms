<?php
namespace AdminController\Post;

use FrontController\Controller as FrontController;

class ViewCategoryController extends FrontController
{

    public function run()
    {
        $this->view()->addView('theme/category-view.html');
    }
}
