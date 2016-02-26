<?php
namespace Admin\Extension;

use App\Resource\Server;

abstract class ExtensionInstances
{

    protected static $extensionArray = [];

    protected static $activeExtension;

    protected static $extensionsDir;

    protected function getActiveExtensionFolderFromUrl()
    {
        $request = Server::getHttpRequest();
        $folderArray = [];

        foreach (self::$extensionArray as $xmlArray) {
            $folderArray = @end(explode(DIRECTORY_SEPARATOR, $xmlArray['extensionDir']));
            $link = strtolower(str_replace('/', '\\/', $folderArray));

            if (preg_match("/(admin\/$link)/", $request)) {
                return $folderArray;
            }
        }
    }
}
