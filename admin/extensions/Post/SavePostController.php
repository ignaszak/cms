<?php
namespace AdminController\Post;

use FrontController\Controller;
use System\Server;
use Content\Controller\Factory;
use Content\Controller\PostController;

class SavePostController extends Controller
{

    public function run()
    {
        // Initialize
        $controller = new Factory(new PostController());

        // Find entity by id to update
        if ($_POST['id']) {
            $controller->find($_POST['id']);
        }

        $alias = $controller->getAlias($_POST['title']);
        $public = @$_POST['public'] == 1 ? 1 : 0;

        $controller->setReference('category', $this->getCategoryId())
            ->setReference('author', $this->view()->getUserId())
            ->setDate(new \DateTime())
            ->setTitle($_POST['title'])
            ->setAlias($alias)
            ->setContent($_POST['content'])
            ->setPublic($public)
            ->insert();

        Server::headerLocation("admin/post/p/edit/$alias");
    }

    private function getCategoryId(): int
    {
        if (! is_numeric(@$_POST['categoryId'])) {
            $this->query()
                ->setContent('category')
                ->limit(1);
            $catArray = $this->query()->getContent();
            return $catArray[0]->getId();
        } else {
            return $_POST['categoryId'];
        }
    }
}
