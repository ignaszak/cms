<?php
namespace AdminController\Menu;

use FrontController\Controller as FrontController;

class AjaxLoadController extends FrontController
{

    public function run()
    {
        $alias = $this->http->router->get('alias');
        $page = $this->http->router->get('page');

        if ($alias != 'category') {
            $content = $this->selectPostOrPage($alias);
        } else { // $page as categoryId
            $content = $this->selectCategory($page);
        }

        $array = [];
        foreach ($content as $row) {
            $rowArray = [];
            $rowArray['id'] = $row->getId();
            $rowArray['title'] = $row->getTitle();
            $rowArray['link'] = "{$alias}/{$row->getAlias()}";
            $rowArray['alias'] = $alias;
            if ($alias == 'post') {
                $rowArray['category'] = $row->getCategory()->getTitle();
            }
            $array[] = $rowArray;
        }

        header("Content-type: application/json; charset=utf-8");
        echo json_encode($array);
        exit();
    }

    /**
     *
     * @param int $catId
     * @return array
     */
    private function selectCategory(int $catId): array
    {
        $this->query->setQuery('category')
            ->id($catId)
            ->limit(1);
        return $this->query->getStaticQuery();
    }

    /**
     *
     * @param string $alias
     * @return array
     */
    private function selectPostOrPage(string $alias): array
    {
        $search = $this->http->request->get('search');
        if (empty($search)) {
            $this->query->setQuery($alias);
        } else {
            $this->query->setQuery($alias)->titleLike($search);
        }
        return $this->query->getStaticQuery();
    }
}
