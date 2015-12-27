<?php

namespace Module;

use Ignaszak\Registry\RegistryFactory;

class Module
{

    public function getCategoryListModule(): string
    {
        $_categoryList = RegistryFactory::start()->register('Module\CategoryList\CategoryList');
        return $_categoryList->getCategoryList();
    }

}
