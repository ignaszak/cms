<?php

namespace Admin\Extension;

class ExtensionLoader extends ExtensionInstances
{

    public function __construct()
    {
        $this->setExtensionsPaths();
        $this->loadXmlExtensionConfigureFiles();
        $this->addRouterPattern();
        $this->loadActiveXmlExtension();
    }

    private function setExtensionsPaths()
    {
        $adminDIR = dirname(dirname(__DIR__));
        parent::$extensionsDir = "$adminDIR/extensions";
    }

    private function loadXmlExtensionConfigureFiles()
    {

        $folderArray = scandir(parent::$extensionsDir);

        foreach ($folderArray as $extension) {
            if (!in_array($extension, array(".", "..", "index"))) 
            {
                $configureFile = parent::$extensionsDir."/$extension/configuration.xml";

                if (file_exists($configureFile)) {
                    parent::$extensionArray = array_merge(parent::$extensionArray, array(
                        array('xml' => simplexml_load_file($configureFile), 'extensionDir' => parent::$extensionsDir."/$extension")
                    ));
                }
            }
        }
    }

    private function addRouterPattern()
    {
        $router = \Ignaszak\Router\Start::instance();

        foreach (parent::$extensionArray as $xmlArray) {
            $xml = $xmlArray['xml'];

            $controllerName = 'admin'.$xml->title;

            foreach ($xml->router->rout->item as $item) {
                $router->add('admin', '(' . ADMIN_URL . ')/' . $item->pattern, $controllerName);
            }

            if (isset($xml->router->token->item)) {
                foreach ($xml->router->token->item as $item) {
                    $router->addToken("$item->name", $item->pattern);
                }
            }

            $router->addController($controllerName, array(
                'file' => "{$xmlArray['extensionDir']}/{$xml->file->script}"
            ));
        }
    }

    private function loadActiveXmlExtension()
    {
        $extensionFolder = $this->getActiveExtensionFolderFromUrl();

        if (!empty($extensionFolder)) {
            $configureFile = parent::$extensionsDir."/$extensionFolder/configuration.xml";
            parent::$activeExtension = simplexml_load_file($configureFile);
        }
    }

}
