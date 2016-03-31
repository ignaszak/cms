<?php
namespace Breadcrumbs;

use App\Resource\RouterStatic as Router;
use Ignaszak\Registry\RegistryFactory;

class CategoryBreadcrumbs extends IBreadcrumbs
{

    /**
     *
     * @var \Entity\Categories[]
     */
    private $breadcrumbsArray = [];

    /**
     *
     * {@inheritDoc}
     * @see \Breadcrumbs\IBreadcrumbs::createBreadcrumbs()
     */
    public function createBreadcrumbs(): array
    {
        $catId = $this->getCategoryId();
        if ($catId) {
            $this->setBreadcrumbsArray();
            return $this->generateBreadcrumbs($catId);
        }
        return $this->getHome();
    }

    /**
     * @return int
     */
    private function getCategoryId(): int
    {
        $group = Router::getGroup();
        $alias = Router::getParam('alias');
        if (! empty($alias)) {
            $this->_query->setQuery($group)
                ->limit(1)
                ->alias($alias);
            $content = $this->_query->getStaticQuery();
            if (count($content)) {
                return ($group == 'category') ?
                    $content[0]->getId() : $content[0]->getCategory()->getId();
            }
        }
        return 0;
    }

    private function setBreadcrumbsArray()
    {
        $this->breadcrumbsArray = RegistryFactory::start()
            ->register('App\Resource\CategoryList')->get();
        usort($this->breadcrumbsArray, function ($a, $b) {
            return $b->getParentId() <=> $a->getParentId();
        });
    }

    /**
     *
     * @param int $catId
     * @return array
     */
    private function generateBreadcrumbs(int $catId): array
    {
        $result = [];
        foreach ($this->breadcrumbsArray as $cat) {
            if ($cat->getId() == $catId) {
                $result[] = $this->addBreadcrumb(
                    $cat->getTitle(),
                    Router::getLink('cat-alias', ['alias' => $cat->getAlias()])
                );
                $catId = $cat->getParentId();
            }
        }
        return array_reverse($result);
    }
}
