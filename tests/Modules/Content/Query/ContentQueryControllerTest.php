<?php

namespace Test\Modules\Content\Query;

use Content\Query\ContentQueryController;
use Test\Init\InitDoctrine;
use Test\Init\InitEntityController;
use Test\Init\InitConf;

class ContentQueryControllerTest extends \PHPUnit_Framework_TestCase
{

    private $_contentQueryController;

    public function setUp()
    {
        InitConf::run();
        $this->_contentQueryController = new ContentQueryController();
    }

    

}
