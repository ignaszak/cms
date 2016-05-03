<?php
namespace Menu;

use Ignaszak\Registry\RegistryFactory;

class Menu
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $query = null;

    /**
     *
     * @var \Conf\Conf
     */
    private $conf = null;

    /**
     *
     * @var \Ignaszak\Router\UrlGenerator
     */
    private $url = null;

    /**
     *
     * @var \Entity\MenuItems[]
     */
    private $menuItemsArray = [];

    public function __construct()
    {
        $this->conf = RegistryFactory::start('file')->register('Conf\Conf');
        $registry = RegistryFactory::start();
        $this->query = $registry->register('DataBase\Query\Query');
        $this->url = $registry->get('url');
    }

    /**
     *
     * @param string $position
     * @return string
     */
    public function getMenu(string $position, string $class = ""): string
    {
        $this->loadMenuItmsByPosition($position);
        return $this->createMenu($class);
    }

    /**
     *
     * @param string $position
     */
    private function loadMenuItmsByPosition(string $position)
    {
        $this->query->setQuery('menu')
            ->findBy('position', $position)
            ->limit(1);
        $content = $this->query->getStaticQuery();

        if (array_key_exists(0, $content)) {
            $this->menuItemsArray = $content[0]->getMenuItems();
        }
    }

    /**
     *
     * @param string $class]
     * @return string
     */
    private function createMenu(string $class): string
    {
        $string = "<ul {$class}>";
        foreach ($this->menuItemsArray as $item) {
            $string .= "<li><a href=\"{$this->generateUrl($item->getAdress())}\">";
            $string .= "{$item->getTitle()}</a></li>";
        }
        $string .= "</ul>";
        return count($this->menuItemsArray) ? $string : "";
    }

    /**
     *
     * @param string $adress
     * @return string
     */
    private function generateUrl(string $adress): string
    {
        if (filter_var($adress, FILTER_VALIDATE_URL)) {
            return $adress;
        } else {
            $adress = json_decode(
                str_replace('|', '"', $adress),
                true
            );
            return $this->url->url(
                $adress['route'],
                $adress['tokens']
            );
        }
    }
}
