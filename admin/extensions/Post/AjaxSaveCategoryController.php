<?php

namespace AdminController\Post;

use FrontController\Controller;
use Content\Controller\Factory;
use Content\Controller\CategoryController;

class AjaxSaveCategoryController extends Controller
{

    public function run()
    {
        if ($_POST['id'] == 1) {return;}
        // Initialize
        $controller = new Factory(new CategoryController);
        // Find entity by id to update
        $refresh = 'refresh';
        if (is_numeric($_POST['id'])) {
            $refresh = '';
            $controller->find($_POST['id']);
        }

        if ($_POST['action'] == 'edit') {

            $alias = $controller->getAlias($_POST['title']);
            $parentId = is_numeric($_POST['parentId']) ? $_POST['parentId'] : 0;

            $controller
                // Sets data
                ->setParentId($parentId)
                ->setTitle($_POST['title'])
                ->setAlias($alias)
                //Execute
                ->insert();

            echo $refresh;

        } elseif ($_POST['action'] == 'delete') {

            $controller->remove();

        }
        exit;
    }

}
