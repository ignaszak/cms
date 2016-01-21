<?php
namespace Controller;

use FrontController\Controller;

class DefaultController extends Controller
{

    public function run()
    {
        $this->view()->addView('post.html');
    }
}
