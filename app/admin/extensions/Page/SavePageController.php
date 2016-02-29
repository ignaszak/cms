<?php
namespace AdminController\Page;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use DataBase\Controller\Controller;
use Entity\Pages;

class SavePageController extends FrontController
{

    public function run()
    {
        // Initialize
        $controller = new Controller(new Pages());
        $date = new \DateTime();

        // Find entity by id to update
        if ($_POST['id']) {
            $controller->find($_POST['id']);
            $date = $controller->entity()->getDate('DateTime');
        }

        $alias = $controller->getAlias($_POST['title']);
        $public = @$_POST['public'] == 1 ? 1 : 0;

        $controller->setReference('author', $this->view()->getUserId())
            ->setDate($date)
            ->setTitle($_POST['title'])
            ->setAlias($alias)
            ->setQuery($_POST['content'])
            ->setPublic($public)
            ->insert([
                'date' => [],
                'title' => [],
                'alias' => [],
                'content' => []
            ]);

        Server::headerLocation("admin/page/edit/$alias");
    }
}
