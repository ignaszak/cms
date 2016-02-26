<?php
namespace FrontController;

abstract class ViewHelperController
{

    /**
     *
     * @var Controller
     */
    protected $_controller;

    /**
     *
     * @param Controller $_controller
     */
    public function __construct(Controller $_controller)
    {
        $this->_controller = $_controller;
    }
}
