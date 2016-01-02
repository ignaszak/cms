<?php

namespace AdminController\Page;

use FrontController\Controller;
use System\Server;
use Content\Controller\Factory;
use Content\Controller\PageController;

class SavePageController extends Controller
{

    public function run()
    {
        // Initialize
        $controller = new Factory(new PageController);

        // Find entity by id to update
        if ($_POST['id']) $controller->find($_POST['id']);

        $alias = $controller->getAlias($_POST['title']);
        $public = @$_POST['public'] == 1 ? 1 : 0;

        $controller
            // Sets data
            ->setReference('author', $this->getUserId())
            ->setDate(new \DateTime)
            ->setTitle($_POST['title'])
            ->setAlias($alias)
            ->setContent($_POST['content'])
            ->setPublic($public)
            //Execute
            ->insert();

        Server::headerLocation("admin/page/edit/$alias");
    }

}
