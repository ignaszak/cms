<?php
namespace AdminController\Post;

use FrontController\Controller;
use Ignaszak\Registry\RegistryFactory;

class AjaxViewCategoryController extends Controller
{

    private $categoryArray = [];

    public function __construct()
    {
        $this->categoryArray = RegistryFactory::start()->register('System\Storage\CategoryList')->get();
    }

    public function run()
    {
        header("Content-type: application/json; charset=utf-8");
        echo $this->getAdminViewCategoryTreeview();
        exit();
    }

    /**
     *
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
                $selected = ($this->view()->getRoute('id') == $cat->getId()) ? ",\n    \"state\" : { \"selected\" : true }" : "";
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
