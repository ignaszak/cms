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
        $this->add();
    }

    private function add()
    {
        $this->validArray = [
            [__CONFDIR__ . "/DB/DBSettings.php", "r"],
            [__CONFDIR__ . "/conf.yml", "r"],
            [__CONFDIR__ . "/router.yml", "r"],
            [__CONFDIR__ . "/view-helper.yml", "r"],
            [__CONFDIR__ . "/admin-view-helper.yml", "r"],
            [__BASEDIR__ . "/.htaccess", "r"],
            [__BASEDIR__ . "/data/cache", "r+"],
            [__BASEDIR__ . "/data/cache/registry", "r+"]
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
