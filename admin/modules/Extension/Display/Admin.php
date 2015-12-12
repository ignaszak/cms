<?php

namespace Admin\Extension\Display;

use Ignaszak\Registry\RegistryFactory;

class Admin extends \Admin\Extension\ExtensionInstances
{

    public function getAdminMenu()
    {
        \Admin\Extension\MenuCreator::createMenu();
        return \Admin\Extension\MenuCreator::getMenu();
    }

    public function getAdminAdress()
    {
        $_conf = RegistryFactory::start('file')->register('Conf\Conf');
        return $_conf->getBaseUrl() . ADMIN_URL;
    }

    public function loadAdminExtensionThemeFile()
    {
        global $cms;
        $themeFile = @parent::$activeExtension->file->theme;
        $extensionDir = $this->getAdminExtensionDir();
        $activeExtensionThemeFile = "$extensionDir/$themeFile";

        if (file_exists($activeExtensionThemeFile) && is_file($activeExtensionThemeFile))
            require ($activeExtensionThemeFile);
    }

    public function getAdminExtensionDir()
    {
        return parent::$extensionsDir . '/' . $this->getActiveExtensionFolderFromUrl();
    }

    public function getAdminlogFileArray()
    {
        return \Ignaszak\Exception\Start::getLogFileArray();
    }

}
