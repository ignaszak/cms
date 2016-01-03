<?php

namespace AdminController\Menu;

use FrontController\Controller;
use System\Router\Storage as Router;

class AjaxLoadController extends Controller
{

    public function run()
    {
        $alias = Router::getRoute('alias');
        $this->view()->setContent($alias)->force();
        $array = array();
        foreach ($this->view()->getContent() as $row) {
            $rowArray = array(
                'id' => $row->getId(),
                'date' => $row->getDate('j F Y, G:i'),
                'title' => $row->getTitle(),
                'text' => substr(strip_tags($row->getText()), 0, 80). '...',
                'author' => $row->getAuthor()->getLogin(),
                'link' => "{$alias}/{$row->getAlias()}",
                'route' => $alias
            );
            if ($alias == 'post') $rowArray['category'] = $row->getCategory()->getTitle();
            $array[] = $rowArray;
        }
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($array);
        exit;
    }

}
