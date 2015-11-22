<?php

namespace Admin\Extension;

class MenuCreator extends ExtensionInstances
{

    private static $sidebarMenu;

    public static function createMenu()
    {
        $baseUrl = \Conf\Conf::instance()->getBaseUrl();
        $menu = "<ul class=\"nav nav-list\" id=\"accordion\">" . PHP_EOL;

        foreach (parent::$extensionArray as $xmlArray) {
            $xml = $xmlArray['xml'];

            $menu .= "<li><a id=\"tree\" href=\"#\">$xml->title</a>" . PHP_EOL;
            $menu .= "<ul class=\"nav nav-list\">";

            foreach ($xml->menu->item as $item) {
                $activeClass = self::returnActiveMenuClass($item->link);
                $menu .= "<li $activeClass><a href=\"{$baseUrl}admin/{$item->link}\" id=\"item\">$item->title</a></li>" . PHP_EOL;
            }

            $menu .= "</ul>" . PHP_EOL . "</li>" . PHP_EOL;
        }

        $menu .= "</ul>";

        self::$sidebarMenu = $menu;
    }

    public static function getMenu()
    {
        return self::$sidebarMenu;
    }

    private static function returnActiveMenuClass($link)
    {
        $link = str_replace('/', '\\/', $link);
        $request = \System\System::getHttpRequest();

        if (preg_match("/($link)/", $request)) {
            return 'class="active"';
        }
    }

}
