<?php
namespace AdminController\Menu;

use FrontController\Controller as FrontController;

class AjaxEditController extends FrontController
{

    public function run()
    {
        $menuItems = $this->getMenuItemsArray();
        $array = [];
        foreach ($menuItems as $item) {
            $adress = json_decode(str_replace('|', '"', $item->getAdress()), true);
            $alias = preg_match('/^(page|post|category)/', $adress['alias']) ? $adress['alias'] : "link";
            $arrayItem = [
                'id' => $item->getId(),
                'alias' => $alias,
                'link' => $item->getAdress(),
                'sequence' => $item->getSequence(),
                'itemTitle' => $item->getTitle()
            ];

            if ($alias != 'link') {
                $this->query->setQuery($alias)
                    ->alias($adress['tokens']['alias'])
                    ->limit(1);
                $content = $this->query->getStaticQuery()[0];
                $arrayItem['title'] = $content->getTitle();

                if ($alias === 'post') {
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
        $this->query->setQuery('menu')
            ->id($this->http->router->get('id'))
            ->limit(1);
        $menu = $this->query->getStaticQuery();
        return $menu[0]->getMenuItems();
    }
}
