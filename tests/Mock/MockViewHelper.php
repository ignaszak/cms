<?php
namespace Test\Mock;

use ViewHelper\ViewHelperExtension;

class MockViewHelper
{

    public static function loadExtensions()
    {
        ViewHelperExtension::addExtensionClass([
            'App\Resource\Route',
            'Breadcrumbs\Breadcrumbs',
            'DataBase\Query\Query',
            'Form\Form',
            'Menu\Menu',
            'Module\Module',
            'Pagination\Pagination',
            'ViewHelper\Extension\Page',
            'ViewHelper\Extension\Post',
            'ViewHelper\Extension\User'
        ]);
    }

    public static function clearExtensions()
    {
        $reflection = new \ReflectionProperty(
            'ViewHelper\ViewHelperExtension',
            'extensionClassNameArray'
        );
        $reflection->setAccessible(true);
        $reflection->setValue(null, []);
    }
}
