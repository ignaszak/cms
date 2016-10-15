<?php
namespace App;

class App
{

    /**
     *
     * @var Message
     */
    private $message = null;

    /**
     *
     * @var Valid
     */
    private $valid = null;

    /**
     *
     * @var Load
     */
    private $load = null;

    public function __construct()
    {
        $this->message = new Message();
        $this->valid = new Valid($this->message);
        $this->load = new Load();
    }

    /**
     * Validates configuration and displays informations if any error occures
     */
    public function validConf()
    {
        $this->valid->validModRewrite();
        $this->valid->valid();
        $this->message->display();
    }

    /**
     * Run application
     */
    public function run()
    {
        $this->load->loadExceptionHandler();
        $this->load->loadSession();
        $this->load->loadAuth();
        $this->load->loadHttp();
        $this->load->loadView();
        $this->load->loadAdmin();
        $this->load->loadFrontController();
        $this->load->loadTheme();
    }

    /**
     *
     * @param object $e
     * @param integer $e
     * @link https://github.com/ignaszak/exception
     */
    public function catchException($e, $type = E_ERROR)
    {
        $this->load->getExceptionHandler()->catchException($e, $type);
    }
}
