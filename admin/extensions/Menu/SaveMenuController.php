<?php

namespace AdminController\Menu;

use FrontController\Controller;
use Content\Controller\Factory;
use Content\Controller\MenuController;
use Content\Controller\MenuItemsController;
use System\Server;

class SaveMenuController extends Controller
{

    public function run()
    {
        $id = @$_POST['id'];
        $name = $_POST['name'];
        $position = $_POST['position'];
        $adressArray = $_POST['menuAdress'];
        $titleArray = $_POST['menuTitle'];
        $idArray = @$_POST['menuId'];

        $controller = new Factory(new MenuController);
        if (!empty($id)) $controller->find($id);
        $controller
            ->setName($name)
            ->setPosition($position)
            ->insert();
        $lastId = $controller->getId();

        $countAdress = count($adressArray);
        for ($i = 0; $i < $countAdress; ++$i) {
            $controller = new Factory(new MenuItemsController);
            if (!empty($idArray[$i])) $controller->find($idArray[$i]);
            $controller
                ->setReference('menu', $lastId)
                ->setTitle($titleArray[$i])
                ->setAdress($adressArray[$i])
                ->insert();
        }

        Server::headerLocation("admin/menu/edit/" . $lastId);
    }

}
