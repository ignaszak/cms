<?php
namespace AdminController\Post;

use FrontController\Controller as FrontController;

class AjaxViewCategoryController extends FrontController
{

    /**
     *
     * @var array
     */
    private $categoryArray = [];

    public function __construct()
    {
        $this->categoryArray = $this->registry
            ->register('App\Resource\CategoryList')->get();
    }

    public function run()
    {
        header("Content-type: application/json; charset=utf-8");
        echo $this->getAdminViewCategoryTreeview();
        exit();
    }

    /**
     *
     * @param int $parentId
     * @return string
     */
    public function getAdminViewCategoryTreeview(int $parentId = 0): string
    {
        $string = "";
        $i = 0;
        foreach ($this->categoryArray as $cat) {
            if ($parentId == $cat->getParentId()) {
                $string .= $i > 0 ? ", " : "";
                $string .= "{\n    \"id\" : {$cat->getId()},";
                $string .= "\n    \"text\" : \"{$cat->getTitle()}\"";
                $selected = ($this->http->router->get('id') == $cat->getId()) ?
                    ",\n    \"state\" : { \"selected\" : true }" : "";
                $string .= $selected;
                $children = $this->getAdminViewCategoryTreeview($cat->getId());
                if (! empty($children)) {
                    $string .= ",\n    \"children\" : [\n";
                    $string .= "        $children";
                    $string .= "\n    ]";
                }
                $string .= "\n}";
                ++ $i;
            }
        }
        return $string ?? "";
    }
}
