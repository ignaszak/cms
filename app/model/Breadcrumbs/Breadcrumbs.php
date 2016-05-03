<?php
namespace Breadcrumbs;

class Breadcrumbs extends IBreadcrumbs
{

    /**
     *
     * @var IBreadcrumbs
     */
    private $breadcrumbs = null;

    /**
     *
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        switch ($this->http->router->group()) {
            case 'post':
            case 'category':
                $this->breadcrumbs = new CategoryBreadcrumbs();
                break;
            case 'date':
                $this->breadcrumbs = new DateBreadcrumbs();
                break;
            case 'search':
                $this->breadcrumbs = new SearchBreadcrumbs();
                break;
            default:
                return $this->getHome();
        }

        $breadcrumbs = $this->breadcrumbs->createBreadcrumbs();
        return $this->addActiveClass($breadcrumbs);
    }

    /**
     * {@inheritDoc}
     * @see \Breadcrumbs\IBreadcrumbs::createBreadcrumbs()
     */
    public function createBreadcrumbs(): array
    {
        return [];
    }

    /**
     *
     * @param array $breadcrumbs
     * @return array
     */
    private function addActiveClass(array $breadcrumbs): array
    {
        $count = count($breadcrumbs);
        $last = $breadcrumbs[$count - 1];
        $last->link = '';
        $last->active = 'active';
        return $breadcrumbs;
    }
}
