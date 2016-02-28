<?php
namespace Test\Model\Content\Query;

use Content\Query\Content;
use Test\Mock\MockDoctrine;
use Test\Mock\MockEntityController;
use Test\Mock\MockConf;

class ContentTest extends \PHPUnit_Framework_TestCase
{

    private $_content;

    private $result;

    public function setUp()
    {
        MockConf::run();
        $this->result = 'anyResult';
        MockDoctrine::queryBuilderResult(array(
            $this->result
        ));
        $this->_content = new Content();
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    public function testReturnResultFromContentQueryBuilder()
    {
        $stub = \Mockery::mock('Entity\Posts');
        MockEntityController::mock('post', $stub);
        $entityName = \PHPUnit_Framework_Assert::readAttribute($this->_content->setContent('post'), 'entityName');
        $this->assertEquals('Entity\Posts', $entityName);
    }
}
