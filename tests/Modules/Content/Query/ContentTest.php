<?php

namespace Test\Modules\Content\Query;

use Content\Query\Content;
use Test\Init\InitDoctrine;

class ContentTest extends \PHPUnit_Framework_TestCase
{

    private $_content;

    public function setUp()
    {
        $this->_content = new Content;
    }

    public function testSelect()
    {
        InitDoctrine::facadeConnection();
    }

}
