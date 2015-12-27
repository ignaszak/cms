<?php

namespace Breadcrumbs;

use System\Router\Storage as Router;
use Ignaszak\Registry\RegistryFactory;
use Content\Query\Content as Query;

class BreadcrumbsGenerator
{

    /**
     * 
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     * @var Query
     */
    private $_query;

    /**
     * @var array
     */
    private $breadcrumbsArray;

    /**
     * @param Query $_query
     * @param array $_categoryArray
     */
    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->_query = new Query;
    }

    /**
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        switch (Router::getRouteName()) {
            case 'post':
            case 'category':
                return $this->createCategoryBreadcrumbs();
                break;
            case 'date':
                return $this->createDateBreadcrumbs();
                break;
            default: return array();
        }
    }

    /**
     * @return array
     */
    private function createDateBreadcrumbs(): array
    {
        $dateArray = explode('-', Router::getRoute('date'));
        $array = array(array(
            'title' => 'Home',
            'id'    => '',
            'link'  => $this->_conf->getBaseUrl()
        ));
        $i = 1;
        foreach ($dateArray as $date) {
            $arraySlice = array_slice($dateArray, 0, $i);
            $link = $arraySlice[0];
            if (array_key_exists(1, $arraySlice)) $link .= "-{$arraySlice[1]}";
            if (array_key_exists(2, $arraySlice)) $link .= "-{$arraySlice[2]}";
            $array[] = array(
                'title' => $i == 2 ? date("F", mktime(0, 0, 0, $date, 1)) : $date,
                'id'    => '',
                'link'  => "{$this->_conf->getBaseUrl()}date/{$link}"
            );
            ++$i;
        }
        return $array;
    }

    /**
     * @return array
     */
    private function createCategoryBreadcrumbs(): array
    {
        $name = Router::getRouteName();
        $alias = Router::getRoute('alias');
        if (!empty($alias)) {
            $this->_query->setContent($name)->limit(1)->alias($alias)->force();
            $content = $this->_query->getContent()[0];
            $categoryId = ($name == 'category') ? $content->getId() : $content->getCategoryId();
            $this->breadcrumbsArray = $this->getCategoryList();
            return $this->generateBreadcrumbs($categoryId);
        }
        return array();
    }

    /**
     * @return \Entity\Categories[]
     */
    private function getCategoryList(): array
    {
        return RegistryFactory::start()
            ->register('System\Storage\CategoryList')->get();
    }

    /**
     * @param int $catId
     * @return array
     */
    private function generateBreadcrumbs(int $catId): array
    {
        $array = array();
        foreach ($this->breadcrumbsArray as $cat) {
            if ($catId == $cat->getId()) {
                $array[] = array(
                    'title' => $cat->getTitle(),
                    'id'    => $cat->getId(),
                    'link'  => $this->_conf->getBaseUrl() . ($cat->getTitle() != 'Home' ?? "category/{$cat->getAlias()}")
                );
                $array = array_merge($this->generateBreadcrumbs($cat->getParentId()), $array);
            }
        }
        return $array;
    }

}
