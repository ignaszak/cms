<?php

namespace Admin\Extension\ViewHelper;

use Ignaszak\Registry\RegistryFactory;
use Ignaszak\Exception\Start as Exception;
use Admin\Extension\MenuCreator;

class Admin extends \Admin\Extension\ExtensionInstances
{

    public function getAdminMenu()
    {
        MenuCreator::createMenu();
        return MenuCreator::getMenu();
    }

    public function getAdminAdress()
    {
        $_conf = RegistryFactory::start('file')->register('Conf\Conf');
        return $_conf->getBaseUrl() . ADMIN_URL;
    }

    public function loadAdminExtensionThemeFile(string $fileName = '')
    {
        $themeFile = $fileName ?? @parent::$activeExtension->file->theme;
        $view = RegistryFactory::start()->get('view');
        $view->loadFile("../../extensions/{$this->getActiveExtensionFolderFromUrl()}/{$themeFile}");
    }

    public function getAdminExtensionDir()
    {
        return parent::$extensionsDir . '/' . $this->getActiveExtensionFolderFromUrl();
    }

    public function getAdminlogFileArray()
    {
        return Exception::getLogFileArray();
    }

}
