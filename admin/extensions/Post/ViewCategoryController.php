<?php

namespace AdminController\Post;

use FrontController\Controller;
use Ignaszak\Registry\RegistryFactory;
use FrontController\ViewHelperController;

class ViewCategoryController extends Controller
{

    public $cms;

    private $categoryArray = array();

    public function __construct()
    {
        $this->cms = RegistryFactory::start()->get('cms');
        $this->getCategoryList();
    }

    public function run()
    {
        header("Content-type: application/json; charset=utf-8");
        $this->setViewHelperName('AdminViewCategory');
        echo $this->getAdminViewCategoryTreeview();
        exit;
    }

    /**
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
                $selected = ($this->cms->getRoute('id') == $cat->getId()) ? ",\n    \"state\" : { \"selected\" : true }" : "";
                $string .= $selected;
                $children = $this->getAdminViewCategoryTreeview($cat->getId());
                if (!empty($children)) {
                    $string .= ",\n    \"children\" : [\n";
                    $string .= "        $children";
                    $string .= "\n    ]";
                }
                $string .= "\n}";
                ++$i;
            }
        }
        return !empty($string) ? "{$string}" : "";
    }

    private function getCategoryList()
    {
        $this->cms->setContent('category')
            ->paginate(false)
            ->force();
        $this->categoryArray = $this->cms->getContent();
    }

}
