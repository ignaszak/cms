<?php
namespace View;

use Ignaszak\Registry\RegistryFactory;

class Conf
{

    /**
     * Current theme absolute path
     *
     * @var string
     */
    private $themePath;

    /**
     *
     * @var string
     */
    private $themeFolder;

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http;

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->http = RegistryFactory::start()->get('http');
    }

    public function configureThemePath()
    {
        if (preg_match('/^admin[a-zA-Z0-9_-]*/', $this->http->router->name())) {
            $this->themeFolder = "view/admin";
            $this->themePath = __VIEWDIR__ . "/admin";
        } else {
            $themeName = $this->_conf->getTheme();
            $this->themeFolder = "view/public/{$themeName}";
            $this->themePath = __VIEWDIR__ . "/public/{$themeName}";
        }
    }

    /**
     *
     * @return string
     */
    public function getThemePath(): string
    {
        return $this->themePath;
    }

    /**
     *
     * @return string
     */
    public function getThemeFolder(): string
    {
        return $this->themeFolder;
    }
}
