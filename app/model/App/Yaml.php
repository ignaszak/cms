<?php
declare(strict_types=1);

namespace App;

use Symfony\Component\Yaml\Parser;

class Yaml
{

    /**
     *
     * @var Parser
     */
    private $parser = null;

    /**
     *
     * @var string
     */
    private $tmpDir = __BASEDIR__ . '/data/cache';

    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     *
     * @param string $file
     * @throws \RuntimeException
     */
    public function parse(string $file): array
    {
        if (! is_readable($file)) {
            throw new \RuntimeException(
                "File '{$file}' does not exists or is not readable"
            );
        } else {
            $tmpFile = "{$this->tmpDir}/" . md5($file) . '.php';
            if (is_readable($tmpFile)) {
                return include $tmpFile ?? [];
            } else {
                $array = $this->changeToArray($file);
                $this->saveArrayToFile($tmpFile, $array);
                return $array;
            }
        }
    }

    /**
     *
     * @param string $file
     * @return array
     */
    private function changeToArray(string $file): array
    {
        return $this->parser->parse(file_get_contents($file)) ?? [];
    }

    /**
     *
     * @param string $file
     * @param array $array
     */
    private function saveArrayToFile(string $file, array $array)
    {
        @file_put_contents(
            $file,
            "<?php\n\nreturn " . var_export($array, true) . ";\n\n"
        );
    }
}
