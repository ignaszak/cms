<?php
namespace View;

use App\Resource\RouterStatic as Router;
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
        if (Router::getGroup() == 'admin') {
            $this->themeFolder = ADMIN_FOLDER . "/themes/Default";
            $this->themePath = __ADMINDIR__ . "/themes/Default";
        } else {
            $themeName = $this->_conf->getTheme();
            $this->themeFolder = "view/themes/{$themeName}";
            $this->themePath = __VIEWDIR__ . "/themes/{$themeName}";
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
