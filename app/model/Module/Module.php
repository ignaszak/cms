<?php
namespace Module;

use Ignaszak\Registry\RegistryFactory;

class Module
{

    /**
     *
     * @param string $arg
     */
    public function getCategoryListModule(string $arg = ''): string
    {
        $categoryList = RegistryFactory::start()
            ->register('Module\CategoryList\CategoryList');
        return $categoryList->getCategoryList($arg);
    }
}
