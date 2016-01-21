<?php
namespace Controller;

use FrontController\Controller;

class ViewPostController extends Controller
{

    public function run()
    {
        $this->view()->addView('post.html');
    }
}
