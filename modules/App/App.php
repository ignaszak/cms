<?php
namespace App;

use App\Conf\Check;

class App
{

    /**
     *
     * @var Message
     */
    private $_message;

    /**
     *
     * @var Valid
     */
    private $_valid;

    /**
     *
     * @var Load
     */
    private $_load;

    public function __construct()
    {
        $this->_message = new Message;
        $this->_valid = new Valid($this->_message);
        $this->_load = new Load;
    }

    /**
     * Validates configuration and displays informations if any error occures
     */
    public function validConf()
    {
        $this->_valid->validModRewrite();
        $this->_valid->valid();
        $this->_message->display();
    }

    /**
     * Run application
     */
    public function run()
    {
        $this->_load->loadExceptionHandler();
        $this->_load->loadRegistryConf();
        $this->_load->loadSession();
        $this->_load->loadRouter();
        $this->_load->loadViewHelper();
        $this->_load->loadRegistry();
        $this->_load->loadAdmin();
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
}
