<?php
namespace App;

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
    private $extensionBaseDir = __ADMINDIR__ . '/extensions';

    public function __construct()
    {
        $this->loadExtensionArray($this->extensionBaseDir);
    }

    /**
     *
     * @return string[]
     */
    public function getAdminExtensionsRouteYaml(): array
    {
        $result = [];
        foreach ($this->extensionsArray as $folder) {
            $file = "{$this->extensionBaseDir}/{$folder}/router.yml";
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
