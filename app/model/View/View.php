<?php
namespace View;

use Ignaszak\Registry\RegistryFactory;

class View
{

    /**
     *
     * @var Conf
     */
    private $_viewConf;

    /**
     *
     * @var ViewHelper
     */
    private $_viewHelper;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http;

    /**
     *
     * @var string
     */
    private $viewFileName;

    public function __construct()
    {
        $registry = RegistryFactory::start();
        $this->_viewConf = new Conf();
        $this->_viewHelper = $registry->register('ViewHelper\ViewHelper');
        $this->http = $registry->get('http');
        $this->configure();
    }

    /**
     * Call methods from ViewHelper
     *
     * @param string $name
     * @param array $arguments
     * @return mixed FiewHelper methods
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->_viewHelper, $name], $arguments);
    }

    /**
     *
     * @param string $fileName
     */
    public function addView(string $fileName)
    {
        $this->viewFileName = $fileName;
    }

    public function loadView()
    {
        if (! empty($this->viewFileName)) {
            if ($this->http->router->group() == 'admin') {
                //$this->loadAdminExtensionThemeFile($this->viewFileName);
            } else {
                $this->loadFile($this->viewFileName);
            }
        }
    }

    /**
     *
     * @param string $fileName
     */
    public function loadFile(string $fileName)
    {
        $file = "{$this->_viewConf->getThemePath()}/{$fileName}";

        if (file_exists($file) && is_file($file) && is_readable($file)) {
            include($file);
        }
    }

    /**
     *
     * @param string $fileName
     * @throws \RuntimeException
     */
    public function loadExtensionFile(string $fileName)
    {
        $file = "{$this->getAdminExtensionDir()}/{$fileName}";
        if (file_exists($file) && is_file($file) && is_readable($file)) {
            include($file);
        } else {
            throw new \RuntimeException("File <b>$file</b> not found");
        }
    }

    /**
     *
     * @return string
     */
    public function getThemeFolder(): string
    {
        return $this->_viewConf->getThemeFolder();
    }

    private function configure()
    {
        $this->_viewConf->configureThemePath();
    }
}
