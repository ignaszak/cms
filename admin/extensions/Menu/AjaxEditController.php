<?php
namespace AdminController\Menu;

use FrontController\Controller as FrontController;
use System\Router\Storage as Router;

class AjaxEditController extends FrontController
{

    public function run()
    {
        $menuItems = $this->getMenuItemsArray();
        $array = [];

        foreach ($menuItems as $item) {
            $adressArray = explode('/', $item->getAdress());
            $alias = preg_match('/^(page|post|category)/', $adressArray[0]) ? $adressArray[0] : "link";
            $arrayItem = [
                'id' => $item->getId(),
                'alias' => $alias,
                'link' => $item->getAdress(),
                'sequence' => $item->getSequence(),
                'itemTitle' => $item->getTitle()
            ];

            if ($alias != 'link') {
                $this->query()
                    ->setContent($alias)
                    ->alias($adressArray[1])
                    ->limit(1)
                    ->paginate(false)
                    ->force();
                $content = $this->query()->getContent()[0];
                $arrayItem['title'] = $content->getTitle();

                if ($alias == 'post') {
                    $arrayItem['category'] = $content->getCategory()->getTitle();
                }
            }

            $array[] = $arrayItem;
        }

        header("Content-type: application/json; charset=utf-8");
        echo json_encode($array);
        exit();
    }

    /**
     *
     * @return MenuItems[]
     */
    private function getMenuItemsArray()
    {
        $this->query()
            ->setContent('menu')
            ->id(Router::getRoute('id'))
            ->limit(1)
            ->paginate(false)
            ->force();
        $menu = $this->query()->getContent();
        return $menu[0]->getMenuItems();
    }
}
