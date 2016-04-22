<?php
namespace AdminController\Post;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use DataBase\Controller\Controller;
use Entity\Posts;

class SavePostController extends FrontController
{

    public function run()
    {
        // Initialize
        $controller = new Controller(new Posts());
        $date = new \DateTime();

        // Find entity by id to update
        if ($_POST['id']) {
            $controller->find($_POST['id']);
            $date = $controller->entity()->getDate('DateTime');
        }

        $alias = $controller->getAlias($_POST['title']);
        $public = @$_POST['public'] == 1 ? 1 : 0;

        $controller->setReference('category', $this->getCategoryId())
            ->setReference('author', $this->view()->getUserId())
            ->setDate($date)
            ->setTitle($_POST['title'])
            ->setAlias($alias)
            ->setContent($_POST['content'])
            ->setPublic($public)
            ->insert([
                'date' => [],
                'title' => [],
                'alias' => [],
                'content' => []
            ]);

        Server::headerLocation("/admin/post/p/edit/{$alias}");
    }

    private function getCategoryId(): int
    {
        if (! is_numeric(@$_POST['categoryId'])) {
            $this->query()->setQuery('category')
                ->limit(1);
            $catArray = $this->query()->getQuery();
            return $catArray[0]->getId();
        } else {
            return $_POST['categoryId'];
        }
    }
}
