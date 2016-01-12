<?php

namespace AdminController\Menu;

use FrontController\Controller;
use Content\Controller\Factory;
use Content\Controller\MenuController;
use Content\Controller\MenuItemsController;
use System\Server;
use System\Router\Storage as Router;

class SaveMenuController extends Controller
{

    /**
     * Last Added Id into \Entity\Menu
     *
     * @var int
     */
    private $lastId;

    public function run()
    {
        if (Router::getRoute('adminMenuAction') == 'save') {

            $this->saveMenuEntityAndSetLastAddedId();
            $this->saveMenuItemsEntity();
            $this->removeMenuItemsEntity();
            Server::headerLocation("admin/menu/edit/{$this->lastId}");

        } elseif (Router::getRoute('adminMenuAction') == 'delete' && !empty($_POST['id'])) {
            $this->removeMenuWithMenuItems();
        }

        Server::headerLocation("admin/menu/view/");
    }

    private function saveMenuEntityAndSetLastAddedId()
    {
        $controller = new Factory(new MenuController);
        if (!empty(@$_POST['id'])) $controller->find($_POST['id']);
        $controller
            ->setName($_POST['name'])
            ->setPosition($_POST['position'])
            ->insert();
        $this->lastId = $controller->getId();
    }

    private function saveMenuItemsEntity()
    {
        $idArray = @$_POST['menuId'];
        $countAdress = count($_POST['menuAdress']);
        for ($i = 0; $i < $countAdress; ++$i) {
            $controller = new Factory(new MenuItemsController);
            if (!empty($idArray[$i])) $controller->find($idArray[$i]);
            $controller
                ->setReference('menu', $this->lastId)
                ->setSequence($_POST['menuSequence'][$i])
                ->setTitle($_POST['menuTitle'][$i])
                ->setAdress($_POST['menuAdress'][$i])
                ->insert();
        }
    }

    private function removeMenuItemsEntity()
    {
        $removeIdArray = @$_POST['menuRemove'];
        $count = count($removeIdArray);
        for ($i = 0; $i < $count; ++$i) {
            $controller = new Factory(new MenuItemsController);
            $controller->find($removeIdArray[$i])
                ->remove();
        }
    }

    private function removeMenuWithMenuItems()
    {
        $controller = new Factory(new MenuController);
        $controller->find(Router::getRoute('id'))
            ->remove();
    }

}
