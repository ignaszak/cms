<?php
namespace App;

use App\Conf\Check;

class App
{

    /**
     *
     * @var View
     */
    private $_message;

    /**
     *
     * @var Load
     */
    private $_load;

    public function __construct()
    {
        $this->_message = new Message;
        $this->_load = new Load;
        $this->validConfiguration();
        if (!$this->isModRewriteEnabled()) {
            $this->_message->catchMessage("Mod rwerite is disabled");
        }
    }

    /**
     * Run application
     */
    public function run()
    {
        $this->_message->display();
        $this->_load->loadExceptionHandler();
        $this->_load->loadSession();
        $this->_load->loadRegistry();
        $this->_load->loadRefererData();
        $this->_load->loadRouter();
        $this->_load->loadAdmin();
        $this->_load->loadViewHelper();
        $this->_load->loadFrontController();
        $this->_load->loadView();
    }

    /**
     *
     * @param object $e
     * @param integer $e
     * @link https://github.com/ignaszak/exception
     */
    public function catchException($e, $type = E_ERROR)
    {
        $this->_load->getException()->catchException($e, $type);
    }

    /**
     * Checks if configuration files and cache folders exist and hve right permissions.
     */
    private function validConfiguration()
    {
        $baseDir = dirname(dirname(__DIR__));

        $check = new Check("{$baseDir}/conf/DB/DBSettings.php");
        if ($check->exists()) {
            $check->isReadable();
        }
        $this->_message->catch($check);

        $check = new Check("{$baseDir}/.htaccess");
        $check->exists();
        $this->_message->catch($check);

        $check = new Check("{$baseDir}/cache");
        if ($check->exists()) {
            $check->isWritable();
        }
        $this->_message->catch($check);

        unset($check);
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
