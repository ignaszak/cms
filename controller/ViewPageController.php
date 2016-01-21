<?php
namespace Controller;

use FrontController\Controller;

class ViewPageController extends Controller
{

    public function run()
    {
        $this->view()->addView('page.html');
    }
}
