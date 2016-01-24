<?php
namespace Admin\Extension;

use System\Server;
use Ignaszak\Registry\RegistryFactory;

class MenuCreator extends ExtensionInstances
{

    /**
     *
     * @var string
     */
    private static $sidebarMenu;

    public static function createMenu()
    {
        $baseUrl = RegistryFactory::start('file')->register('Conf\Conf')
            ->getBaseUrl();
        $menu = "<ul id=\"accordion\" class=\"accordion\">" . PHP_EOL;

        foreach (parent::$extensionArray as $xmlArray) {
            $xml = $xmlArray['xml'];

            $liActive = self::returnActiveMenuClass($xml->base, 'li');
            $menu .= "<li {$liActive}>
                        <div class=\"link\"><i class=\"{$xml->icon}\">
                            </i>{$xml->title}<i class=\"fa fa-chevron-down\"></i>
                        </div>" . PHP_EOL;

            $ulActive = self::returnActiveMenuClass($xml->base, 'ul');
            $menu .= "<ul class=\"submenu\" {$ulActive}>";

            foreach ($xml->menu->item as $item) {
                $aActive = self::returnActiveMenuClass("{$xml->base}/{$item->link}", 'a');
                $menu .= "<li>
                            <a href=\"{$baseUrl}admin/{$xml->base}/{$item->link}\" {$aActive}>
                                {$item->title}
                            </a>
                         </li>";
            }

            $menu .= "</ul>" . PHP_EOL . "</li>" . PHP_EOL;
        }

        $menu .= "</ul>";

        self::$sidebarMenu = $menu;
    }

    /**
     *
     * @return string
     */
    public static function getMenu(): string
    {
        return self::$sidebarMenu;
    }

    /**
     *
     * @param string $link
     * @param string $elemrnt
     * @return string
     */
    private static function returnActiveMenuClass(string $link, string $element): string
    {
        $link = str_replace('/', '\\/', $link);
        $request = Server::getHttpRequest();

        if (preg_match("/($link)/", $request)) {
            if ($element == 'li') {
                return 'class="open"';
            } elseif ($element == 'ul') {
                return 'style="display:block"';
            } elseif ($element == 'a') {
                return 'class="active"';
            }
        }
        return '';
    }
}
