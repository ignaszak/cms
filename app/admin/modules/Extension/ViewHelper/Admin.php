<?php
namespace Admin\Extension\ViewHelper;

use Ignaszak\Registry\RegistryFactory;
use Admin\Extension\MenuCreator;

class Admin extends \Admin\Extension\ExtensionInstances
{

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf;

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
    }

    public function getAdminMenu()
    {
        MenuCreator::createMenu();
        return MenuCreator::getMenu();
    }

    public function getAdminThemeUrl()
    {
        return $this->_conf->getBaseUrl() . '/app/' . ADMIN_URL;
    }

    public function getAdminAdress()
    {
        return $this->_conf->getBaseUrl() . '/' . ADMIN_URL;
    }

    public function loadAdminExtensionThemeFile(string $fileName = '')
    {
        $themeFile = $fileName ?? @parent::$activeExtension->file->theme;
        $view = RegistryFactory::start()->get('view');
        $view->loadFile(
            "../../extensions/{$this->getActiveExtensionFolderFromUrl()}/{$themeFile}"
        );
    }

    public function getAdminExtensionDir()
    {
        return parent::$extensionsDir . '/' .
            $this->getActiveExtensionFolderFromUrl();
    }
}
