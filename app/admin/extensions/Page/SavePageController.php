<?php
namespace AdminController\Page;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use DataBase\Controller\Controller;
use Entity\Pages;

class SavePageController extends FrontController
{

    /**
     *
     * @var array
     */
    private $request = [];

    public function run()
    {
        $this->request = $this->http->request->all();

        // Initialize
        $controller = new Controller(new Pages());
        $date = new \DateTime();

        // Find entity by id to update
        if ($this->request['id']) {
            $controller->find($this->request['id']);
            $date = $controller->entity()->getDate('DateTime');
        }

        $alias = $controller->getAlias($this->request['title']);
        $public = @$this->request['public'] == 1 ? 1 : 0;

        $controller->setReference('author', $this->view->getUserId())
            ->setDate($date)
            ->setTitle($this->request['title'])
            ->setAlias($alias)
            ->setContent($this->request['content'])
            ->setPublic($public)
            ->insert([
                'date' => [],
                'title' => [],
                'alias' => [],
                'content' => []
            ]);

        Server::headerLocation($this->url('admin-page-edit', [
                'action' => 'edit', 'alias' => $alias
        ]));
    }
}
