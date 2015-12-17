<?php

namespace AdminController\Post;

use FrontController\Controller;
use Ignaszak\Registry\RegistryFactory;
use ViewHelper\ViewHelperExtension;

class ViewController extends Controller
{

    private $cms;

    public function __construct()
    {
        $this->cms = RegistryFactory::start()->get('cms');
    }

    public function run()
    {
        $this->loadDisplay();
    }

    public function loadDisplay()
    {
        $saveName = 'ViewPost';
        RegistryFactory::start()->set($saveName, $this->setDisplay());
        ViewHelperExtension::addExtensionClass($saveName);
    }

    public function setDisplay()
    {
    
        return new class () {

            public function getViewPostList()
            {
                return 'test';
            }

        };
    }

}