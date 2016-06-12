<?php
namespace AdminController\Post;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use DataBase\Command\Command;
use Entity\Posts;

class SavePostController extends FrontController
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
        $controller = new Command(new Posts());
        $date = new \DateTime();

        // Find entity by id to update
        if ($this->request['id']) {
            $controller->find($this->request['id']);
            $date = $controller->entity()->getDate('DateTime');
        }

        $alias = $controller->getAlias($this->request['title']);
        $public = (int) $this->request['public'] ?? 0;

        $controller->setReference('category', $this->getCategoryId())
            ->setReference('author', $this->view->getUserId())
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

        Server::headerLocation(
            $this->url('admin-post-edit', [
                'action' => 'edit', 'alias' => $alias
            ])
        );
    }

    private function getCategoryId(): int
    {
        if (! is_numeric(@$this->request['categoryId'])) {
            $this->query->setQuery('category')
                ->limit(1);
            $catArray = $this->query->getQuery();
            return $catArray[0]->getId();
        } else {
            return $this->request['categoryId'];
        }
    }
}
