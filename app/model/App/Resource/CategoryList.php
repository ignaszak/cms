<?php
namespace App\Resource;

use Ignaszak\Registry\RegistryFactory;

class CategoryList
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $query = null;

    /**
     *
     * @var Http
     */
    private $http = null;

    /**
     *
     * @var \Entity\Categories[]
     */
    private $categoryArray = [];

    public function __construct()
    {
        $registry = RegistryFactory::start();
        $this->http = $registry->get('http');
        $this->query = RegistryFactory::start()->register('DataBase\Query\Query');
        $this->query->setQuery('category');
        $this->categoryArray = $this->query->getStaticQuery();
    }

    /**
     *
     * @param string $alias
     * @return integer
     */
    public function getIdByAlias(string $alias): int
    {
        $this->query->setQuery('category')->alias($alias);
        $content = $this->query->getStaticQuery();
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
        $alias = $alias ?? $this->http->router->get('alias');
        if (! empty($alias)) {
            $parentId = $this->getIdByAlias($alias);
            $array[] = $parentId;
        }
        foreach ($this->categoryArray as $cat) {
            if ($parentId === $cat->getParentId()) {
                $array[] = $cat->getId();
                $array = array_merge($this->child("", $cat->getId()), $array);
            }
        }
        return $array;
    }
}
