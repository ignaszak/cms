<?php

namespace Test\Modules\Content\Query;

use Content\Query\Content;
use Test\Init\InitDoctrine;
use Test\Init\InitEntityController;
use Test\Init\InitConf;

class ContentTest extends \PHPUnit_Framework_TestCase
{

    private $_content;

    public function setUp()
    {
        $this->_content = new Content;
    }

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testReturnResultFromContentQueryBuilder()
    {
        InitConf::run();
        $result = 'anyResult';
        InitDoctrine::queryBuilderResult(array($result));
        $stub = \Mockery::mock('Entity\Posts');
        InitEntityController::mock('post', $stub);
        $this->assertEquals(
            array($result),
            $this->_content->setContent('post')->getContent()
        );
    }

}
