<?php

namespace AdminController\Menu;

use FrontController\Controller;
use System\Router\Storage as Router;
use Entity\MenuItems;

class AjaxEditController extends Controller
{

    public function run()
    {
        $menuItems = $this->getMenuItemsArray();
        $array = array();
        foreach ($menuItems as $item) {
            $adressArray = explode('/', $item->getAdress());
            $alias = preg_match('/^(page|post|category)/', $adressArray[0]) ?
                $adressArray[0] : "link";
            $arrayItem = array(
                'id' => $item->getId(),
                'alias' => $alias,
                'link' => $item->getAdress(),
                'sequence' => $item->getSequence(),
                'itemTitle' => $item->getTitle()
            );

            if ($alias != 'link') {
                $this->view()->setContent($alias)
                    ->alias($adressArray[1])
                    ->limit(1)
                    ->paginate(false)
                    ->force();
                $content = $this->view()->getContent()[0];
                $arrayItem['title'] = $content->getTitle();

                if ($alias == 'post')
                    $arrayItem['category'] = $content->getCategory()->getTitle();
            }

            $array[] = $arrayItem;
        }

        header("Content-type: application/json; charset=utf-8");
        echo json_encode($array);
        exit;
    }
    
    /**
     * @return MenuItems[]
     */
    private function getMenuItemsArray()
    {
        $this->view()->setContent('menu')
            ->id(Router::getRoute('id'))
            ->limit(1)
            ->paginate(false)
            ->force();
        $menu = $this->view()->getContent();
        return $menu[0]->getMenuItems();
    }

}
