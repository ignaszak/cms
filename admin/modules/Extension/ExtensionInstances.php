<?php

namespace Admin\Extension;

abstract class ExtensionInstances
{
    protected static $extensionArray = array();
    protected static $activeExtension;
    protected static $extensionsDir;

    protected function getActiveExtensionFolderFromUrl()
    {
        $request = \System\System::getHttpRequest();
        $folderArray = array();

        foreach (self::$extensionArray as $xmlArray) {
            $folderArray = end(@explode('/', $xmlArray['extensionDir']));
            $link = str_replace('/', '\\/', $folderArray);

            if (preg_match("/(admin\/$link)/", $request)) {
                return $folderArray;
            }
        }
    }
}