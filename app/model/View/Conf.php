<?php
namespace View;

use Ignaszak\Registry\RegistryFactory;

class Conf
{

    /**
     *
     * @var \Conf\Conf
     */
    private $conf = null;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http = null;

    /**
     * Current theme absolute path
     *
     * @var string
     */
    private $themePath = '';

    /**
     *
     * @var string
     */
    private $themeFolder = '';

    public function __construct()
    {
        $this->conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->http = RegistryFactory::start()->get('http');
    }

    public function configureThemePath()
    {
        if ($this->http->isAdmin()) {
            $this->themeFolder = "view/admin";
            $this->themePath = __VIEWDIR__ . "/admin";
        } else {
            $themeName = $this->conf->getTheme();
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
