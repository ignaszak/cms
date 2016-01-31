<?php
namespace AdminController\Post;

use FrontController\Controller;
use Content\Controller\Factory;
use Content\Controller\CategoryController;
use Ignaszak\Registry\RegistryFactory;

class AjaxSaveCategoryController extends Controller
{

    private $categoryArray = array();

    public function __construct()
    {
        $this->categoryArray = RegistryFactory::start()
            ->register('System\Storage\CategoryList')->get();
    }

    public function run()
    {
        if ($_POST['id'] == 1) {
            return;
        }

        // Initialize
        $controller = new Factory(new CategoryController());
        // Find entity by id to update
        $refresh = 'refresh';

        if (is_numeric($_POST['id'])) {
            $refresh = '';
            $controller->find($_POST['id']);
        }

        if ($_POST['action'] == 'edit') {

            $alias = $controller->getAlias($_POST['title']);
            $parentId = is_numeric($_POST['parentId']) ? $_POST['parentId'] : 0;

            $controller->setParentId($parentId)
                ->setTitle($_POST['title'])
                ->setAlias($alias)
                ->insert();

            echo $refresh;

        } elseif ($_POST['action'] == 'delete') {

            $controller = new Factory(new CategoryController());
            $idArray = array_filter($this->getChildCategories($_POST['id']));
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
            if ($parentId == $cat->getParentId()) {
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
