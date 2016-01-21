<?php
namespace Admin\Extension;

use System\Server;

abstract class ExtensionInstances
{

    protected static $extensionArray = array();

    protected static $activeExtension;

    protected static $extensionsDir;

    protected function getActiveExtensionFolderFromUrl()
    {
        $request = Server::getHttpRequest();
        $folderArray = array();
        
        foreach (self::$extensionArray as $xmlArray) {
            $folderArray = @end(explode(DIRECTORY_SEPARATOR, $xmlArray['extensionDir']));
            $link = strtolower(str_replace('/', '\\/', $folderArray));
            
            if (preg_match("/(admin\/$link)/", $request)) {
                return $folderArray;
            }
        }
    }
}
