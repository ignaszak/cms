<?php
namespace App\Conf;

use CMSException\FileException;

class Check
{

    /**
     *
     * @var string[]
     */
    private $messageArray = array();

    public function fileExists(string $filename): bool
    {
        if (! file_exists($filename)) {
            $this->messageArray[] = "File '{$filename}' not exist.";
            return false;
        }
        return true;
    }

    public function isWritable(string $filename): bool
    {
        if (! is_writable($filename)) {
            $this->messageArray[] = "Permission denied could not write to '{$filename}'";
            return false;
        }
        return true;
    }

    public function isReadable(string $filename): bool
    {
        if (! is_readable($filename)) {
            $this->messageArray[] = "Permission denied could not read from '{$filename}'";
            return false;
        }
        return true;
    }
}
