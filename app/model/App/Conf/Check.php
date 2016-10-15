<?php
namespace App\Conf;

class Check
{

    /**
     *
     * @var string
     */
    private $file = '';

    /**
     *
     * @var array
     */
    private $messageArray = [];

    /**
     *
     * @param string $file
     */
    public function add(string $file)
    {
        $this->file = $file;
    }

    /**
     *
     * @return boolean
     */
    public function exists(): bool
    {
        if (! file_exists($this->file)) {
            $this->messageArray[] = "'{$this->file}' not exist.";
            return false;
        }
        return true;
    }

    /**
     *
     * @return boolean
     */
    public function isWritable(): bool
    {
        if (! is_writable($this->file)) {
            $this->messageArray[] = "Permission denied could not write to '{$this->file}'";
            return false;
        }
        return true;
    }

    /**
     *
     * @return boolean
     */
    public function isReadable(): bool
    {
        if (! is_readable($this->file)) {
            $this->messageArray[] = "Permission denied could not read from '{$this->file}'";
            return false;
        }
        return true;
    }

    /**
     *
     * @return array
     */
    public function getMessage(): array
    {
        return $this->messageArray;
    }
}
