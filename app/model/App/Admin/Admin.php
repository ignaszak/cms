<?php
declare(strict_types=1);

namespace App\Admin;

use App\Yaml;
use Ignaszak\Registry\RegistryFactory;

class Admin
{

    /**
     *
     * @var AdminExtension
     */
    private $_adminExtension = null;

    /**
     *
     * @var Yaml
     */
    private $_yaml = null;

    /**
     *
     * @var RegistryFactory
     */
    private $_registry = null;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http = null;

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf = null;

    /**
     *
     * @param AdminExtension $_adminExtension
     * @param Yaml $_yaml
     */
    public function __construct(
        AdminExtension $_adminExtension,
        Yaml $_yaml
    ) {
        $this->_adminExtension = $_adminExtension;
        $this->_yaml = $_yaml;
        $this->_registry = RegistryFactory::start();
        $this->http = $this->_registry->get('http');
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
    }

    /**
     *
     * @return array
     */
    public function getAdminMenu(): array
    {
        $url = $this->_registry->get('url');
        $http = $this->_registry->get('http');
        $menus = [];
        foreach ($this->_adminExtension->extensionsArray as $folder) {
            $conf = $this->_yaml->parse(
                "{$this->_adminExtension->extensionDir}/{$folder}/conf.yml"
            );
            $conf['active'] = $http->router->group() == $folder;
            if (isset($conf['menu'])) {
                foreach ($conf['menu'] as $key => $value) {
                    $conf['menu'][$key]['active'] = $http->router->name() == $conf['menu'][$key]['url'];
                    $conf['menu'][$key]['url'] = $url->url(
                        $conf['menu'][$key]['url'],
                        $conf['menu'][$key]['tokens'] ?? []
                    );
                    unset($conf['menu'][$key]['tokens']);
                }
            }
            $menus[] = $conf;
        }
        return $menus;
    }

    public function getAdminThemeUrl()
    {
        return $this->_conf->getBaseUrl() . '/app/' . ADMIN_URL;
    }

    public function getAdminAdress()
    {
        return $this->_conf->getBaseUrl() . '/' . ADMIN_URL;
    }

    public function loadAdminExtensionThemeFile(string $fileName = '')
    {
        $extension = ucfirst($this->_registry->get('http')->router->group());
        $this->_registry->get('view')->loadFile(
            "../../admin/extensions/{$extension}/{$fileName}"
        );
    }
}
