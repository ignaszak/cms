<?php
namespace AdminController\Post;

use FrontController\Controller as FrontController;
use DataBase\Command\Command;
use Entity\Categories;

class AjaxSaveCategoryController extends FrontController
{

    /**
     *
     * @var array
     */
    private $categoryArray = [];

    /**
     *
     * @var array
     */
    private $request = [];

    public function __construct()
    {
        $this->categoryArray = $this->registry
            ->register('App\Resource\CategoryList')->get();
        $this->request = $this->http->request->all();
    }

    public function run()
    {
        if ($this->request['id'] === 1) {
            return;
        }

        // Initialize
        $controller = new Command(new Categories());
        // Find entity by id to update
        $refresh = 'refresh';

        if (is_numeric($this->request['id'])) {
            $refresh = '';
            $controller->find($this->request['id']);
        }

        if ($this->request['action'] === 'edit') {
            $alias = $controller->getAlias($this->request['title']);
            $parentId = is_numeric($this->request['parentId']) ?
                $this->request['parentId'] : 0;

            $controller->setParentId($parentId)
                ->setTitle($this->request['title'])
                ->setAlias($alias)
                ->insert([
                    'title' => [],
                    'alias' => []
                ]);

            echo $refresh;
        } elseif ($this->request['action'] === 'delete') {
            $controller = new Command(new Categories());
            $idArray = array_filter(
                $this->getChildCategories($this->request['id'])
            );
            $controller->findBy(['id' => $idArray])
                ->remove();
        }

        exit;
    }

    /**
     *
     * @param int $parentId
     * @return array
     */
    private function getChildCategories(int $parentId): array
    {
        $array = [];
        $array[] = $parentId;
        foreach ($this->categoryArray as $cat) {
            if ($parentId === $cat->getParentId()) {
                $array[] = $cat->getId();
                $array = array_merge(
                    $array,
                    $this->getChildCategories($cat->getId())
                );
            }
        }
        return $array;
    }
}
