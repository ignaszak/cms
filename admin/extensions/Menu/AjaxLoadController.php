<?php

namespace AdminController\Menu;

use FrontController\Controller;
use System\Router\Storage as Router;

class AjaxLoadController extends Controller
{

    public function run()
    {
        $alias = Router::getRoute('alias');
        $page = Router::getRoute('page');

        if ($alias != 'category') {
            $content = $this->selectPostOrPage($alias);
        } else { // $page as categoryId
            $content = $this->selectCategory($page);
        }

        $array = array();
        foreach ($content as $row) {
            $rowArray = array();
            $rowArray['id'] = $row->getId();
            $rowArray['title'] = $row->getTitle();
            $rowArray['link'] = "{$alias}/{$row->getAlias()}";
            $rowArray['alias'] = $alias;
            if ($alias == 'post') $rowArray['category'] = $row->getCategory()->getTitle();
            $array[] = $rowArray;
        }

        header("Content-type: application/json; charset=utf-8");
        echo json_encode($array);
        exit;
    }

    /**
     * @return array
     */
    private function selectCategory(int $catId): array
    {
        $this->view()->setContent('category')
            ->id($catId)
            ->limit(1)
            ->paginate(false)
            ->force();
        return $this->view()->getContent();
    }

    /**
     * @return array
     */
    private function selectPostOrPage(string $alias): array
    {
        if (empty(@$_POST['search'])) {
            $this->view()->setContent($alias)
                ->force();
        } else {
            $this->view()->setContent($alias)
                ->titleLike($_POST['search'])
                ->paginate(false)
                ->force();
        }
        return $this->view()->getContent();
    }

}
