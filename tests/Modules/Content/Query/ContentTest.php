<?php

namespace Test\Modules\Content\Query;

use Content\Query\Content;
use Test\Init\InitDoctrine;
use Test\Init\InitEntityController;
use Test\Init\InitConf;

class ContentTest extends \PHPUnit_Framework_TestCase
{

    private $_content;
    private $result;

    public function setUp()
    {
        InitConf::run();
        $this->result = 'anyResult';
        InitDoctrine::queryBuilderResult(array($this->result));
        $this->_content = new Content;
    }

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testReturnResultFromContentQueryBuilder()
    {
        $stub = \Mockery::mock('Entity\Posts');
        InitEntityController::mock('post', $stub);
        $entityName = \PHPUnit_Framework_Assert::readAttribute(
            $this->_content->setContent('post'),
        'entityName');
        $this->assertEquals(
            'Entity\Posts',
            $entityName
        );
    }

}
