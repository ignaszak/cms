<?php

namespace AdminController\Post;

use FrontController\Controller;
use System\Server;
use Content\Controller\Factory;
use Content\Controller\PostController;
use Ignaszak\Registry\RegistryFactory;

class SaveController extends Controller
{

    private $cms;

    public function __construct()
    {
        $this->cms = RegistryFactory::start()->get('cms');
    }

    public function run()
    {
        // Initialize
        $controller = new Factory(new PostController);

        // Find entity by id to update
        if ($_POST['id']) $controller->find($_POST['id']);

        // Sets data
        $controller->setReference('category', $this->getCategoryId());
        $controller->setReference('author', $this->cms->getUserId());
        $controller->setDate(new \DateTime);
        $controller->setTitle($_POST['title']);
        $alias = $controller->getAlias($_POST['title']);
        $controller->setAlias($alias);
        $controller->setContent($_POST['content']);
        $public = @$_POST['public'] == 1 ? 1 : 0;
        $controller->setPublic($public);

        // Execute
        $controller->insert();

        Server::headerLocation("admin/post/edit/$alias");
    }

    private function getCategoryId(): int
    {
        if (!array_key_exists('categoryId', $_POST)) {
            $this->cms->setContent('category')->limit(1);
            $catArray = $this->cms->getContent();
            return $catArray[0]->getId();
        } else {
            return $_POST['categoryId'];
        }
    }

}
