<?php

namespace Breadcrumbs;

use System\Router\Storage as Router;
use Content\Query\Content as Query;
use Ignaszak\Registry\RegistryFactory;

class BreadcrumbsGenerator
{

    /**
     * @var \Content\Query\Content
     */
    private $_query;

    /**
     * @var Entity\Categories[]
     */
    private $categoryArray;

    /**
     * @param Query $_query
     * @param array $_categoryArray
     */
    public function __construct()
    {
        $this->_query = new Query();
        $this->categoryArray = $this->getCategoryList();
    }

    /**
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        switch (Router::getRouteName()) {
            case 'post':
            case 'category':
                return $this->switchBreadcrumbs();
                break;
            default: return array();
        }
    }

    /**
     * @return array
     */
    private function getCategoryList(): array
    {
        $this->_query->setContent('category')
            ->paginate(false)
            ->force();
        return $this->_query->getContent();
    }

    /**
     * @return array
     */
    private function switchBreadcrumbs(): array
    {
        $name = Router::getRouteName();
        $alias = Router::getRoute('alias');
        if (!empty($alias)) {
            $this->_query->setContent($name)->limit(1)->alias($alias)->force();
            $content = $this->_query->getContent()[0];
            $categoryId = ($name == 'category') ? $content->getId() : $content->getCategoryId();
            return $this->generateBreadcrumbs($categoryId);
        }
        return array();
    }

    /**
     * @param int $catId
     * @return array
     */
    private function generateBreadcrumbs(int $catId): array
    {
        $conf = RegistryFactory::start('file')->register('Conf\Conf');
        $array = array();
        foreach ($this->categoryArray as $cat) {
            if ($catId == $cat->getId()) {
                $array[] = array(
                    'title' => $cat->getTitle(),
                    'id'    => $cat->getId(),
                    'link'  => "{$conf->getBaseUrl()}category/{$cat->getAlias()}"
                );
                $array = array_merge($this->generateBreadcrumbs($cat->getParentId()), $array);
            }
        }
        return $array;
    }

}
