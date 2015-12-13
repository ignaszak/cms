<?php

namespace AdminController\Post;

use FrontController\Controller;
use System\Server;
use System\Router\Storage as Router;
use Content\Controller\Factory;
use Content\Controller\PostController;

class SaveController extends Controller
{

    public function run()
    {

        // Initialize
        $controller = new Factory(new PostController);

        // Find entity by id to update
        if ($_POST['id']) $controller->find($_POST['id']);

        // Sets data
        $catId = @$_POST['categoryId'];
        $controller->setReference('category', $catId);
        $controller->setReference('author', 1);
        $controller->setDate(new \DateTime);
        $controller->setTitle($_POST['title']);
        $alias = $controller->getAlias($_POST['title']);
        $controller->setAlias($alias);
        $controller->setContent($_POST['content']);

        // Execute
        $controller->insert();

        Server::headerLocation("admin/post/edit/$alias");
    }

}
