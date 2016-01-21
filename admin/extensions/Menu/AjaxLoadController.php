<?php
namespace AdminController\Menu;

use FrontController\Controller;

class AjaxLoadController extends Controller
{

    public function run()
    {
        $alias = $this->view()->getRoute('alias');
        $page = $this->view()->getRoute('page');
        
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
     * @return array
     */
    private function selectCategory(int $catId): array
    {
        $this->query()
            ->setContent('category')
            ->id($catId)
            ->limit(1)
            ->paginate(false)
            ->force();
        return $this->query()->getContent();
    }

    /**
     *
     * @return array
     */
    private function selectPostOrPage(string $alias): array
    {
        if (empty(@$_POST['search'])) {
            $this->query()
                ->setContent($alias)
                ->force();
        } else {
            $this->query()
                ->setContent($alias)
                ->titleLike($_POST['search'])
                ->paginate(false)
                ->force();
        }
        return $this->query()->getContent();
    }
}
