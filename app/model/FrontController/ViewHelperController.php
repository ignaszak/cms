<?php
namespace FrontController;

abstract class ViewHelperController
{

    /**
     *
     * @var Controller
     */
    protected $controller = null;

    /**
     *
     * @param Controller $controller
     */
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }
}
