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
        $controller = new Factory(new PageController());
        $date = new \DateTime();

        // Find entity by id to update
        if ($_POST['id']) {
            $controller->find($_POST['id']);
            $date = $controller->entity()->getDate('DateTime');
        }

        $alias = $controller->getAlias($_POST['title']);
        $public = @$_POST['public'] == 1 ? 1 : 0;

        $controller->setReference('author', $this->view()
            ->getUserId())
            ->setDate($date)
            ->setTitle($_POST['title'])
            ->setAlias($alias)
            ->setContent($_POST['content'])
            ->setPublic($public)
            ->insert();

        Server::headerLocation("admin/page/edit/$alias");
    }
}
