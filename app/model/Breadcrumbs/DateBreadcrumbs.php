<?php
namespace Breadcrumbs;

use App\Resource\RouterStatic as Router;

class DateBreadcrumbs extends IBreadcrumbs
{

    /**
     *
     * {@inheritDoc}
     * @see \Breadcrumbs\IBreadcrumbs::createBreadcrumbs()
     */
    public function createBreadcrumbs(): array
    {
        $paramsArray = Router::getParams();
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
                    Router::getLink('date', $params)
                );
            }
        }
        return $result;
    }
}
