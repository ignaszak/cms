<?php
namespace Breadcrumbs;

use System\Router\Storage as Router;

class DateBreadcrumbs extends IBreadcrumbs
{

    /**
     *
     * {@inheritDoc}
     * @see \Breadcrumbs\IBreadcrumbs::createBreadcrumbs()
     */
    public function createBreadcrumbs(): array
    {
        $dateArray = explode('-', Router::getRoute('date'));
        $array = $this->getHome();
        $i = 1;
        foreach ($dateArray as $date) {
            $array[] = $this->addBreadcrumb(
                $i == 2 ? date("F", mktime(0, 0, 0, $date, 1)) : $date,
                'date/' .  implode('-', array_slice($dateArray, 0, $i))
            );
            ++ $i;
        }
        return $array;
    }
}
