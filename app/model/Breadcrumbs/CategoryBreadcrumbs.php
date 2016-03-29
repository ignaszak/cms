<?php
namespace Breadcrumbs;

use App\Resource\RouterStatic as Router;
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
        $group = Router::getGroup();
        $alias = Router::getParam('alias');
        if (! empty($alias)) {
            $this->_query->setQuery($group)
                ->limit(1)
                ->alias($alias);
            $content = $this->_query->getStaticQuery();
            if (! empty($content)) {
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
    }

    /**
     *
     * @param int $catId
     * @return array
     */
    private function generateBreadcrumbs(int $catId): array
    {
        $array = [];$i = 0;
        foreach ($this->breadcrumbsArray as $cat) {
            ++$i;
            if ($catId == $cat->getId()) {
                echo $cat->getAlias().'<br>';
                Router::getLink('cat-alias', [
                    'alias' => 'dupa'
                ]);
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
        echo $i;
        return $array;
    }
}
