<?php
namespace AdminController\Menu;

use FrontController\Controller as FrontController;
use Content\Controller\Controller;
use Entity\Menus;
use Entity\MenuItems;
use App\Resource\Server;

class SaveMenuController extends FrontController
{

    /**
     * Last Added Id into \Entity\Menu
     *
     * @var int
     */
    private $lastId;

    /**
     *
     * @var string
     */
    public $action;

    /**
     *
     * @var integer
     */
    public $id;

    public function run()
    {
        $this->action = $this->view()->getRoute('action');
        $this->id = $this->view()->getRoute('id');

        if ($this->action == 'save') {

            $this->saveMenuEntityAndSetLastAddedId();
            $this->saveMenuItemsEntity();
            $this->removeMenuItemsEntity();
            Server::headerLocation("admin/menu/edit/{$this->lastId}");
        } elseif ($this->action == 'delete' && $this->id) {
            $this->removeMenuWithMenuItems();
        }

        Server::headerLocation("admin/menu/view/");
    }

    private function saveMenuEntityAndSetLastAddedId()
    {
        $controller = new Controller(new Menus());
        $unique = ['unique'];
        if (! empty(@$_POST['id'])) {
            $controller->find($_POST['id']);
            $unique = [];
        }
        $controller->setName($_POST['name'])
            ->setPosition($_POST['position'])
            ->insert([
                'name' => $unique,
                'position' => $unique
            ]);
        $this->lastId = $controller->entity()->getId();
    }

    private function saveMenuItemsEntity()
    {
        $idArray = @$_POST['menuId'];
        $countAdress = count($_POST['menuAdress']);
        for ($i = 0; $i < $countAdress; ++ $i) {
            $controller = new Controller(new MenuItems());
            if (! empty($idArray[$i])) {
                $controller->find($idArray[$i]);
            }
            $controller->setReference('menu', $this->lastId)
                ->setSequence($_POST['menuSequence'][$i])
                ->setTitle($_POST['menuTitle'][$i])
                ->setAdress($_POST['menuAdress'][$i])
                ->insert([
                    'title' => []
                ]);
        }
    }

    private function removeMenuItemsEntity()
    {
        $removeIdArray = @$_POST['menuRemove'];
        $count = count($removeIdArray);
        for ($i = 0; $i < $count; ++ $i) {
            $controller = new Controller(new MenuItems());
            $controller->find($removeIdArray[$i])->remove();
        }
    }

    private function removeMenuWithMenuItems()
    {
        $controller = new Controller(new Menus());
        $controller->find($this->id)->remove();
    }
}
