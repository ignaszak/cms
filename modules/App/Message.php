<?php
namespace App;

class Message
{

    /**
     *
     * @var array
     */
    private $messageArray = array();

    /**
     *
     * @param Conf\Check $_check
     */
    public function catch(Conf\Check $_check)
    {
        $array2 = $_check->getMessage();
        $this->messageArray = array_merge($this->messageArray, $array2);
    }

    /**
     *
     * @param string $message
     */
    public function catchMessage(string $message)
    {
        if (!empty($message)) {
            $this->messageArray[] = $message;
        }
    }

    /**
     * If exists display messages and exit.
     */
    public function display()
    {
        if (count($this->messageArray)) {
            echo "<h1>ignaszak/cms</h1>\n";
            echo "<h2>Follow errors detected:</h2>\n";
            $i = 0;
            foreach ($this->messageArray as $error) {
                echo ++$i . ". {$error}<br>\n";
            }
            exit;
        }
    }
}
