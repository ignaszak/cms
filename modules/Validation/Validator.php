<?php

namespace Validation;

use Aura\Filter\FilterFactory;

abstract class Validator
{

    protected static $_auraFilter;

    public function __construct()
    {
        if (empty(self::$_auraFilter)) {
            $filterFactory = new FilterFactory();
            self::$_auraFilter = $filterFactory->newValueFilter();
        }
    }

}
