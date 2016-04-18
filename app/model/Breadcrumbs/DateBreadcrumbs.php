<?php
namespace Breadcrumbs;

class DateBreadcrumbs extends IBreadcrumbs
{

    /**
     *
     * {@inheritDoc}
     * @see \Breadcrumbs\IBreadcrumbs::createBreadcrumbs()
     */
    public function createBreadcrumbs(): array
    {
        $paramsArray = $this->http->router->all();
        $result = $this->getHome();
        foreach ($paramsArray as $key => $date) {
            if (is_numeric($date)) {
                $params = $paramsArray;
                if ($key == 'year') {
                    $params['s1'] = '';
                    $params['s2'] = '';
                    $params['day'] = '';
                    $params['month'] = '';
                } elseif ($key == 'month') {
                    $params['s2'] = '';
                    $params['day'] = '';
                }
                $result[] = $this->addBreadcrumb(
                    $date,
                    $this->registry->get('url')->url('date', $params)
                );
            }
        }
        return $result;
    }
}
