<?php

namespace View;

use Ignaszak\Registry\RegistryFactory;
use CMSException\InvalidFileException;

class View
{

    /**
     * @var Conf
     */
    private $_viewConf;

    /**
     * @var ViewHelper
     */
    private $_viewHelper;

    /**
     * @var string
     */
    private $viewFileName;

    public function __construct()
    {
        $this->_viewConf = new Conf;
        $this->_viewHelper = RegistryFactory::start()->register('ViewHelper\ViewHelper');
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
        return call_user_func_array(array(
            $this->_viewHelper,
            $name
        ), $arguments);
    }

    /**
     * @param string $fileName
     */
    public function addView(string $fileName)
    {
        $this->viewFileName = $fileName;
    }

    public function loadView()
    {
        $this->loadFile($this->viewFileName);
    }

    /**
     * @param string $fileName
     */
    public function loadFile(string $fileName)
    {
        $file = "{$this->_viewConf->getThemePath()}/{$fileName}";

        if (file_exists($file) && is_file($file) && is_readable($file)) {
            include_once($file);
        }
    }

    /**
     * @param string $fileName
     */
    public function loadExtensionFile(string $fileName)
    {
        $file = "{$this->getAdminExtensionDir()}/{$fileName}";
        if (file_exists($file) && is_file($file) && is_readable($file)) {
            include_once($file);
        } else {
            throw new InvalidFileException("File <b>$file</b> not found");
        }
    }

    /**
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
