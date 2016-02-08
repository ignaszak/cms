<?php
namespace Controller;

use FrontController\Controller as FrontController;

class DefaultController extends FrontController
{

    public function run()
    {
        $this->view()->addView('post.html');
    }
}
