<?php
namespace Breadcrumbs;

class SearchBreadcrumbs extends IBreadcrumbs
{
    /**
     * {@inheritDoc}
     * @see \Breadcrumbs\IBreadcrumbs::createBreadcrumbs()
     */
    public function createBreadcrumbs(): array
    {
        return array_merge(
            $this->getHome(),
            [
                $this->addBreadcrumb('Search', $this->_conf->getBaseUrl())
            ]
        );
    }
}
