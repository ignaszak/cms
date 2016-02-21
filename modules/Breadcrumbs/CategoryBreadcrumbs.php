<?php
namespace Breadcrumbs;

use System\Router\Storage as Router;
use Ignaszak\Registry\RegistryFactory;

class CategoryBreadcrumbs extends IBreadcrumbs
{

    /**
     *
     * @var array
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
        $name = Router::getRouteName();
        $alias = Router::getRoute('alias');
        if (! empty($alias)) {
            $this->_query->setContent($name)
                ->limit(1)
                ->alias($alias)
                ->force();
            $content = $this->_query->getContent();
            if ($content) {
                return ($name == 'category') ?
                    $content[0]->getId() : $content[0]->getCategory()->getId();
            }
        }
        return 0;
    }

    private function setBreadcrumbsArray()
    {
        $this->breadcrumbsArray = RegistryFactory::start()
            ->register('System\Storage\CategoryList')->get();
    }

    /**
     *
     * @param int $catId
     * @return array
     */
    private function generateBreadcrumbs(int $catId): array
    {
        $array = [];
        foreach ($this->breadcrumbsArray as $cat) {
            if ($catId == $cat->getId()) {
                $array[] = $this->addBreadcrumb(
                    $cat->getTitle(),
                    ($cat->getTitle() != 'Home' ?
                        "category/{$cat->getAlias()}" : "")
                );
                $array = array_merge(
                    $this->generateBreadcrumbs($cat->getParentId()),
                    $array
                );
            }
        }
        return $array;
    }
}
