<?php
namespace System\Storage;

use Content\Query\Content as Query;
use System\Router\Storage as Router;

class CategoryList
{

    /**
     *
     * @var Query
     */
    private $_query;

    /**
     *
     * @var \Entity\Categories[]
     */
    private $categoryArray;

    public function __construct()
    {
        $this->_query = new Query();
        $this->_query->setContent('category')
            ->paginate(false)
            ->force();
        $this->categoryArray = $this->_query->getContent();
    }

    /**
     *
     * @param string $alias
     * @return integer
     */
    public function getIdByAlias(string $alias): int
    {
        $this->_query->setContent('category')
            ->alias($alias)
            ->force();
        $content = $this->_query->getContent();
        return $content ? $content[0]->getId() : 0;
    }

    /**
     *
     * @return \Entity\Categories[]
     */
    public function get(): array
    {
        return $this->categoryArray;
    }

    /**
     *
     * @param string $alias
     * @return \Entity\Categories[]
     */
    public function child(string $alias = null, int $parentId = 0): array
    {
        $array = [];
        $alias = $alias ?? Router::getRoute('alias');
        if (! empty($alias)) {
            $parentId = $this->getIdByAlias($alias);
            $array[] = $parentId;
        }
        foreach ($this->categoryArray as $cat) {
            if ($parentId == $cat->getParentId()) {
                $array[] = $cat->getId();
                $array = array_merge($this->child("", $cat->getId()), $array);
            }
        }
        return $array;
    }
}
