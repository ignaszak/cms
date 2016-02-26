<?php
namespace App;

use App\Conf\Check;

/**
 * Checks if configuration files and cache folders exist and have right permissions.
 */
class Valid
{

    /**
     *
     * @var Message
     */
    private $_message;

    /**
     *
     * @var Conf\Check
     */
    private $_check;

    /**
     *
     * @var string
     */
    private $baseDir;

    /**
     *
     * @var array
     */
    private $validArray = [];

    /**
     *
     * @param Message $_message
     */
    public function __construct(Message $_message)
    {
        $this->_message = $_message;
        $this->_check = new Check;
        $this->baseDir = dirname(dirname(__DIR__));
        $this->add();
    }

    private function add()
    {
        $this->validArray = [
            ["{$this->baseDir}/conf/DB/DBSettings.php", "r"],
            ["{$this->baseDir}/.htaccess", "r"],
            ["{$this->baseDir}/cache", "r+"],
            ["{$this->baseDir}/conf/exception-handler.php", "r"],
            ["{$this->baseDir}/cache/registry", "r+"],
            ["{$this->baseDir}/conf/router.php", "r"],
            ["{$this->baseDir}/" . ADMIN_FOLDER . "/conf/view-helper.php", "r"],
            ["{$this->baseDir}/conf/view-helper.php", "r"]
        ];
    }

    public function valid()
    {
        foreach ($this->validArray as $valid) {
            $this->_check->add($valid[0]);
            if ($this->_check->exists()) {
                if ($valid[1] == "r") {
                    $this->_check->isReadable();
                }
                if ($valid[1] == "r+") {
                    $this->_check->isReadable();
                    $this->_check->isWritable();
                }
            }
        }
        $this->_message->catch($this->_check);
    }

    public function validModRewrite()
    {
        if (!$this->isModRewriteEnabled()) {
            $this->_message->catchMessage("Mod rwerite is disabled");
        }
    }

    /**
     * @return boolean
     */
    private function isModRewriteEnabled(): bool
    {
        if (function_exists('apache_get_modules')) {
            return in_array('mod_rewrite', apache_get_modules());
        } else {
            return getenv('HTTP_MOD_REWRITE') == 'On' ? true : false;
        }
    }
}
