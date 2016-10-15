<?php
namespace Module\CategoryList;

use Ignaszak\Registry\RegistryFactory;

class CategoryList
{

    /**
     *
     * @var \Conf\Conf
     */
    private $conf = null;

    /**
     *
     * @var \App\Resource\CategoryList
     */
    private $categoryList = null;

    /**
     *
     * @var \Ignaszak\Router\UrlGenerator
     */
    private $url = null;

    public function __construct()
    {
        $this->conf = RegistryFactory::start('file')->register('Conf\Conf');
        $registry = RegistryFactory::start();
        $this->categoryList = $registry->register('App\Resource\CategoryList')->get();
        $this->url = $registry->get('url');
    }

    /**
     *
     * @param string $arg
     * @param int $parentId
     * @return string
     */
    public function getCategoryList(string $arg, int $parentId = 1): string
    {
        $string = "<ul {$arg}>";
        if (array_key_exists(0, $this->categoryList)) {
            $string .= "<li><a href=\"{$this->url->url('default')}\">";
            $string .= "{$this->categoryList[0]->getTitle()}</a>";
            $string .= "</li>";
        }
        $categoriesExists = count($this->categoryList);
        unset($this->categoryList[0]);
        foreach ($this->categoryList as $cat) {
            if ($parentId === $cat->getParentId()) {
                $url = $this->url->url('category-alias', [
                    'alias' => $cat->getAlias()
                ]);
                $string .= "<li><a href=\"{$url}\">";
                $string .= "{$cat->getTitle()}</a>";
                $string .= $this->getCategoryList($arg, $cat->getId());
                $string .= "</li>";
            }
        }
        $string .= "</ul>";
        return $categoriesExists ? $string : "";
    }
}
