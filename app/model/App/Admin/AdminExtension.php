<?php
declare(strict_types=1);

namespace App\Admin;

/**
 *
 * @author Tomasz Ignaszak
 *
 * @property-read string[] $extensionsArray
 * @property-read string $extensionDir
 */
class AdminExtension
{

    /**
     *
     * @var string[]
     */
    private $extensionsArray = [];

    /**
     *
     * @var string
     */
    private $extensionDir = '';

    /**
     *
     * @param string $extensionDir
     */
    public function __construct(string $extensionDir)
    {
        if (! empty($extensionDir)) {
            $this->extensionDir = $extensionDir;
            $this->loadExtensionArray($this->extensionDir);
        }
    }

    /**
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }

    /**
     *
     * @return string[]
     */
    public function getAdminExtensionsRouteYaml(): array
    {
        $result = [];
        foreach ($this->extensionsArray as $folder) {
            $file = "{$this->extensionDir}/{$folder}/router.yml";
            if (file_exists($file)) {
                $result[] = $file;
            }
        }
        return $result;
    }

    /**
     *
     * @param string $extensionBaseDir
     */
    private function loadExtensionArray(string $extensionBaseDir)
    {
        $this->extensionsArray = array_diff(
            scandir($extensionBaseDir),
            ['.', '..']
        );
    }
}
