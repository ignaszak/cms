<?php
namespace AdminController\Menu;

use FrontController\Controller as FrontController;
use DataBase\Controller\Controller;
use Entity\Menus;
use Entity\MenuItems;
use App\Resource\Server;

class SaveMenuController extends FrontController
{

    /**
     *
     * @var string
     */
    public $action = '';

    /**
     *
     * @var integer
     */
    public $id = 0;

    /**
     * Last Added Id into \Entity\Menu
     *
     * @var int
     */
    private $lastId = 0;

    /**
     *
     * @var array
     */
    private $request = [];

    public function run()
    {
        $this->action = $this->http->router->get('action');
        $this->id = $this->http->router->get('id');
        $this->request = $this->http->request->all();

        if ($this->action === 'save') {
            $this->saveMenuEntityAndSetLastAddedId();
            $this->saveMenuItemsEntity();
            $this->removeMenuItemsEntity();
            Server::headerLocation(
                $this->url('admin-menu-edit', [
                    'action' => 'edit', 'id' => $this->lastId
                ])
            );
        } elseif ($this->action === 'delete' && $this->id) {
            $this->removeMenuWithMenuItems();
        }

        Server::headerLocation(
            $this->url('admin-menu-list', ['action' => 'view'])
        );
    }

    private function saveMenuEntityAndSetLastAddedId()
    {
        $controller = new Controller(new Menus());
        $unique = ['unique'];
        if (! empty($this->request['id'])) {
            $controller->find($this->request['id']);
            $unique = [];
        }
        $controller->setName($this->request['name'])
            ->setPosition($this->request['position'])
            ->insert([
                'name' => $unique,
                'position' => $unique
            ]);
        $this->lastId = $controller->entity()->getId();
    }

    private function saveMenuItemsEntity()
    {
        $idArray = $this->request['menuId'] ?? [];
        $countAdress = count($this->request['menuAdress']);
        for ($i = 0; $i < $countAdress; ++ $i) {
            $controller = new Controller(new MenuItems());
            if (! empty($idArray[$i])) {
                $controller->find($idArray[$i]);
            }
            $controller->setReference('menu', $this->lastId)
                ->setSequence($this->request['menuSequence'][$i])
                ->setTitle($this->request['menuTitle'][$i])
                ->setAdress($this->request['menuAdress'][$i])
                ->insert([
                    'title' => []
                ]);
        }
    }

    private function removeMenuItemsEntity()
    {
        $removeIdArray = $this->request['menuRemove'] ?? [];
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
