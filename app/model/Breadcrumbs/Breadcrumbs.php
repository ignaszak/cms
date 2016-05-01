<?php
namespace Breadcrumbs;

class Breadcrumbs extends IBreadcrumbs
{

    /**
     *
     * @var IBreadcrumbs
     */
    private $_breadcrumbs;

    /**
     *
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        switch ($this->http->router->group()) {
            case 'post':
            case 'category':
                $this->_breadcrumbs = new CategoryBreadcrumbs();
                break;
            case 'date':
                $this->_breadcrumbs = new DateBreadcrumbs();
                break;
            case 'search':
                $this->_breadcrumbs = new SearchBreadcrumbs();
                break;
            default:
                return $this->getHome();
        }

        $breadcrumbs = $this->_breadcrumbs->createBreadcrumbs();
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
