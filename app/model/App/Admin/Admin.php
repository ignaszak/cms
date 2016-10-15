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
    private $adminExtension = null;

    /**
     *
     * @var Yaml
     */
    private $yaml = null;

    /**
     *
     * @var RegistryFactory
     */
    private $registry = null;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http = null;

    /**
     *
     * @var \Conf\Conf
     */
    private $conf = null;

    /**
     *
     * @param AdminExtension $adminExtension
     * @param Yaml $yaml
     */
    public function __construct(
        AdminExtension $adminExtension,
        Yaml $yaml
    ) {
        $this->adminExtension = $adminExtension;
        $this->yaml = $yaml;
        $this->registry = RegistryFactory::start();
        $this->http = $this->registry->get('http');
        $this->conf = RegistryFactory::start('file')->register('Conf\Conf');
    }

    /**
     *
     * @return array
     */
    public function getAdminMenu(): array
    {
        $url = $this->registry->get('url');
        $http = $this->registry->get('http');
        $menus = [];
        foreach ($this->adminExtension->extensionsArray as $folder) {
            $conf = $this->yaml->parse(
                "{$this->adminExtension->extensionDir}/{$folder}/conf.yml"
            );
            $conf['active'] = $http->router->group() === $folder;
            if (isset($conf['menu'])) {
                foreach ($conf['menu'] as $key => $value) {
                    $conf['menu'][$key]['active'] = $http->router->name() === $conf['menu'][$key]['url'];
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
        return $this->conf->getBaseUrl() . '/app/' . ADMIN_URL;
    }

    public function getAdminAdress()
    {
        return $this->conf->getBaseUrl() . '/' . ADMIN_URL;
    }

    public function loadAdminExtensionThemeFile(string $fileName = '')
    {
        $extension = ucfirst($this->registry->get('http')->router->group());
        $this->registry->get('view')->loadFile(
            "../../admin/extensions/{$extension}/{$fileName}"
        );
    }
}
