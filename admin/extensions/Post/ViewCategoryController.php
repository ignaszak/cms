<?php

namespace AdminController\Post;

use FrontController\Controller;
use Ignaszak\Registry\RegistryFactory;
use FrontController\ViewHelperController;

class ViewCategoryController extends Controller
{

    public $cms;

    public function __construct()
    {
        $this->cms = RegistryFactory::start()->get('cms');
    }

    public function run()
    {
        $this->setViewHelperName('AdminViewCategory');
    }

    /**
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class ($this) extends ViewHelperController
        {
            public $categoryArray = array();
            
            public function __construct(Controller $_controller)
            {
                parent::__construct($_controller);
                $this->getCategoryList();
            }
            /**
             * @return \Entity\Categories[]
             */
            public function getAdminViewCategory(): array
            {
                return $this->categoryArray;
            }

            /**
             * @return string
             */
            public function getAdminViewCategoryTreeview(int $parentId = 0): string
            {
                $string = "";
                foreach ($this->categoryArray as $cat) {
                    if ($parentId == $cat->getParentId()) {
                        $string .= "<li><input type=\"checkbox\" name=\"cat[]\" value=\"{$cat->getId()}\">
                            {$cat->getTitle()}";
                        $string .= $this->getAdminViewCategoryTreeview($cat->getId());
                        $string .= "</li>";
                    }
                }
                return !empty($string) ? "\n<ul>\n{$string}\n</ul>\n" : "";
            }

            private function getCategoryList()
            {
                $this->_controller->cms->setContent('category')
                ->paginate(false)
                ->force();
                $this->categoryArray = $this->_controller->cms->getContent();
            }
        };
    }

}
