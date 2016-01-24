<?php
namespace View;

use System\Router\Storage as Router;
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

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
    }

    public function configureThemePath()
    {
        $baseDir = dirname(dirname(__DIR__));

        if (Router::isRouteName('admin')) {
            $adminFolder = defined('ADMIN_FOLDER') ? ADMIN_FOLDER : "admin";
            $this->themeFolder = "{$adminFolder}/themes/Default";
            $this->themePath = "{$baseDir}/{$this->themeFolder}";
        } else {
            $this->themeFolder = "themes/{$this->_conf->getTheme()}";
            $this->themePath = "{$baseDir}/{$this->themeFolder}";
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
