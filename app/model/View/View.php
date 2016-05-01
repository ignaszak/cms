<?php
declare(strict_types=1);

namespace View;

use Ignaszak\Registry\RegistryFactory;

class View
{

    /**
     *
     * @var Conf
     */
    private $conf = null;

    /**
     *
     * @var ViewHelper
     */
    private $viewHelper = null;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http = null;

    /**
     *
     * @var \Ignaszak\Registry\Registry
     */
    private $registry = null;

    /**
     *
     * @var string
     */
    private $viewFileName;

    /**
     *
     * @param ViewHelper $viewHelper
     */
    public function __construct(ViewHelper $viewHelper)
    {
        $this->registry = RegistryFactory::start();
        $this->viewHelper = $viewHelper;
        $this->http = $this->registry->get('http');
        $this->conf = new Conf();
        $this->conf->configureThemePath();
    }

    /**
     *
     * @param string $method
     * @param array $arguments
     * @throws \RuntimeException
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        $methods = $this->viewHelper->getMethods();
        $class = $methods[$method] ?? null;
        if (is_null($class)) {
            throw new \RuntimeException("Method '{$method}' does not exists");
        } else {
            $instance = $this->registry->register($class);
            return call_user_func_array([$instance, $method], $arguments);
        }
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
            if (preg_match('/^admin[a-zA-Z0-9_-]*/', $this->http->router->name())) {
                $this->loadAdminExtensionThemeFile($this->viewFileName);
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
        $file = "{$this->conf->getThemePath()}/{$fileName}";
        if (file_exists($file) && is_file($file) && is_readable($file)) {
            include($file);
        }
    }

    /**
     *
     * @return string
     */
    public function getThemeFolder(): string
    {
        return $this->conf->getThemeFolder();
    }
}
